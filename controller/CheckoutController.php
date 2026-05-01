<?php
class CheckoutController extends BaseController {

    private function sqlSafe($s){
        return str_replace("'","''",(string)$s);
    }

    public function index(){
        if(empty($_SESSION['user_id'])){
            $_SESSION['error']='Vui lòng đăng nhập để thanh toán.';
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        if(empty($_SESSION['cart']) || !is_array($_SESSION['cart'])){
            $_SESSION['cart']=[];
        }
        if(count($_SESSION['cart'])===0){
            $_SESSION['cart_error']='Giỏ hàng trống.';
            header('Location: index.php?controller=cart');
            exit;
        }
        $this->loadModel('PaymentMethodModel');
        $paymentMethodModel=new PaymentMethodModel();
        $methods=$paymentMethodModel->getAllMethod();
        $cartTotal=0;
        foreach($_SESSION['cart'] as $line){
            $cartTotal+=(int)($line['price'] ?? 0)*(int)($line['qty'] ?? 0);
        }
        $checkoutError=$_SESSION['checkout_error'] ?? null;
        unset($_SESSION['checkout_error']);
        $this->loadModel('CategoryModel');
        $categoryModel=new CategoryModel();
        return $this->view('frontend.checkout.index',[
            'methods'=>$methods,
            'cart'=>$_SESSION['cart'],
            'cartTotal'=>$cartTotal,
            'checkoutError'=>$checkoutError,
            'menus'=>$categoryModel->getCategoryForMenu(),
        ]);
    }

    public function store(){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            header('Location: index.php?controller=checkout');
            exit;
        }
        if(empty($_SESSION['user_id'])){
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        if(empty($_SESSION['cart']) || !is_array($_SESSION['cart']) || count($_SESSION['cart'])===0){
            header('Location: index.php?controller=cart');
            exit;
        }
        $address=trim((string)($_POST['address'] ?? ''));
        $phone=trim((string)($_POST['phone'] ?? ''));
        $note=trim((string)($_POST['note'] ?? ''));
        $methodId=(int)($_POST['method_id'] ?? 0);
        if($address==='' || $phone==='' || $methodId<1){
            $_SESSION['checkout_error']='Vui lòng nhập địa chỉ, số điện thoại và chọn phương thức thanh toán.';
            header('Location: index.php?controller=checkout');
            exit;
        }
        $this->loadModel('PaymentMethodModel');
        $paymentMethodModel=new PaymentMethodModel();
        $methodRow=$paymentMethodModel->findByPaymentMethodId($methodId);
        if(empty($methodRow)){
            $_SESSION['checkout_error']='Phương thức thanh toán không hợp lệ.';
            header('Location: index.php?controller=checkout');
            exit;
        }
        $cartTotal=0;
        foreach($_SESSION['cart'] as $line){
            $cartTotal+=(int)($line['price'] ?? 0)*(int)($line['qty'] ?? 0);
        }
        if($cartTotal<=0){
            $_SESSION['checkout_error']='Giỏ hàng không hợp lệ.';
            header('Location: index.php?controller=checkout');
            exit;
        }
        $this->loadModel('InvoiceModel');
        $invoiceModel=new InvoiceModel();
        $invoiceData=[
            'user_id'=>(int)$_SESSION['user_id'],
            'status_id'=>1,
            'address'=>$this->sqlSafe($address),
            'phone'=>$this->sqlSafe($phone),
            'total_amount'=>$cartTotal,
            'created_at'=>date('Y-m-d H:i:s'),
            'note'=>$this->sqlSafe($note),
        ];
        $invoiceId=$invoiceModel->insertInvoiceReturnId($invoiceData);
        if($invoiceId<1){
            $_SESSION['checkout_error']='Không tạo được đơn hàng.';
            header('Location: index.php?controller=checkout');
            exit;
        }
        $this->loadModel('InvoiceDetailModel');
        $invoiceDetailModel=new InvoiceDetailModel();
        foreach($_SESSION['cart'] as $variantKey=>$line){
            $invoiceDetailModel->insertInvoiceDetail([
                'variant_id'=>(int)$variantKey,
                'invoice_id'=>$invoiceId,
                'price'=>(int)($line['price'] ?? 0),
                'quantity'=>(int)($line['qty'] ?? 0),
            ]);
        }
        $this->loadModel('PaymentModel');
        $paymentModel=new PaymentModel();
        $paymentModel->insertPayment([
            'invoice_id'=>$invoiceId,
            'method_id'=>$methodId,
            'payment_date'=>date('Y-m-d'),
            'payment_amount'=>$cartTotal,
        ]);
        $_SESSION['cart']=[];
        header('Location: index.php?controller=checkout&action=success&invoice_id='.$invoiceId);
        exit;
    }

    public function success(){
        if(empty($_SESSION['user_id'])){
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        $invoiceId=(int)($_GET['invoice_id'] ?? 0);
        if($invoiceId<1){
            header('Location: index.php?controller=invoice&action=index');
            exit;
        }
        $this->loadModel('InvoiceModel');
        $invoiceModel=new InvoiceModel();
        $invoice=$invoiceModel->findByInvoiceId($invoiceId);
        if(empty($invoice) || (int)($invoice['user_id'] ?? 0)!==(int)$_SESSION['user_id']){
            header('Location: index.php?controller=invoice&action=index');
            exit;
        }
        $this->loadModel('StatusModel');
        $statusModel=new StatusModel();
        $orderStatus=$statusModel->findByStatusId((int)($invoice['status_id'] ?? 0));
        $this->loadModel('CategoryModel');
        $categoryModel=new CategoryModel();
        return $this->view('frontend.checkout.success',[
            'invoice'=>$invoice,
            'status'=>$orderStatus,
            'menus'=>$categoryModel->getCategoryForMenu(),
        ]);
    }
}
?>
