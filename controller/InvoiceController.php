<?php
class InvoiceController extends BaseController{
    private $invoiceModel;

    public function __construct()
    {
        $this->loadModel('InvoiceModel');
        $this->invoiceModel=new InvoiceModel();
    }

    public function index(){
        if(empty($_SESSION['user_id'])){
            $_SESSION['error']='Vui lòng đăng nhập.';
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        $invoiceList=$this->invoiceModel->getInvoicesForUserWithStatus((int)$_SESSION['user_id']);
        $this->loadModel('CategoryModel');
        $categoryModel=new CategoryModel();
        return $this->view('frontend.invoices.index',[
            'invoices'=>$invoiceList,
            'menus'=>$categoryModel->getCategoryForMenu(),
        ]);
    }

    public function show(){
        if(empty($_SESSION['user_id'])){
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        $id=$_GET['invoice_id'] ?? null;
        if($id===null){
            header('Location: index.php?controller=invoice&action=index');
            exit;
        }
        $invoice=$this->invoiceModel->findByInvoiceId((int)$id);
        if(empty($invoice) || (int)($invoice['user_id'] ?? 0)!==(int)$_SESSION['user_id']){
            header('Location: index.php?controller=invoice&action=index');
            exit;
        }
        $this->loadModel('InvoiceDetailModel');
        $invoiceDetailModel=new InvoiceDetailModel();
        $details=$invoiceDetailModel->getRowsWithProductForInvoice((int)$id);
        $this->loadModel('StatusModel');
        $statusModel=new StatusModel();
        $status=$statusModel->findByStatusId((int)($invoice['status_id'] ?? 0));
        $this->loadModel('PaymentModel');
        $paymentModel=new PaymentModel();
        $payments=$paymentModel->findPaymentByInvoiceId((int)$id);
        $paymentRow=!empty($payments) ? $payments[0] : null;
        $paymentMethodName='';
        if(!empty($paymentRow['method_id'])){
            $this->loadModel('PaymentMethodModel');
            $paymentMethodModel=new PaymentMethodModel();
            $pm=$paymentMethodModel->findByPaymentMethodId((int)$paymentRow['method_id']);
            $paymentMethodName=(string)($pm['name'] ?? '');
        }
        $canCancel=false;
        if(!empty($status['name']) && trim((string)$status['name'])==='Chờ xác nhận'){
            $canCancel=true;
        }
        if((int)($invoice['status_id'] ?? 0)===1){
            $canCancel=true;
        }
        $invoiceMessage=$_SESSION['invoice_message'] ?? null;
        unset($_SESSION['invoice_message']);
        $this->loadModel('CategoryModel');
        $categoryModel=new CategoryModel();
        return $this->view('frontend.invoices.show',[
            'invoice'=>$invoice,
            'details'=>$details,
            'status'=>$status,
            'payment'=>$paymentRow,
            'paymentMethodName'=>$paymentMethodName,
            'canCancel'=>$canCancel,
            'invoiceMessage'=>$invoiceMessage,
            'menus'=>$categoryModel->getCategoryForMenu(),
        ]);
    }

    public function cancel(){
        if(empty($_SESSION['user_id'])){
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            header('Location: index.php?controller=invoice&action=index');
            exit;
        }
        $invoiceId=(int)($_POST['invoice_id'] ?? 0);
        if($invoiceId<1){
            header('Location: index.php?controller=invoice&action=index');
            exit;
        }
        $invoice=$this->invoiceModel->findByInvoiceId($invoiceId);
        if(empty($invoice) || (int)($invoice['user_id'] ?? 0)!==(int)$_SESSION['user_id']){
            header('Location: index.php?controller=invoice&action=index');
            exit;
        }
        $this->loadModel('StatusModel');
        $statusModel=new StatusModel();
        $current=$statusModel->findByStatusId((int)($invoice['status_id'] ?? 0));
        $pendingName=trim((string)($current['name'] ?? ''));
        $isPending=((int)($invoice['status_id'] ?? 0)===1) || ($pendingName==='Chờ xác nhận');
        if(!$isPending){
            $_SESSION['invoice_message']='Chỉ hủy được khi đơn còn trạng thái Chờ xác nhận.';
            header('Location: index.php?controller=invoice&action=show&invoice_id='.$invoiceId);
            exit;
        }
        $cancelled=$statusModel->findFirstByStatusName('Đã hủy');
        if($cancelled===null || empty($cancelled['id'])){
            $_SESSION['invoice_message']='Chưa có trạng thái Đã hủy trong hệ thống.';
            header('Location: index.php?controller=invoice&action=show&invoice_id='.$invoiceId);
            exit;
        }
        $this->invoiceModel->updateStatus((int)$cancelled['id'],$invoiceId);
        $_SESSION['invoice_message']='Đã hủy đơn hàng.';
        header('Location: index.php?controller=invoice&action=show&invoice_id='.$invoiceId);
        exit;
    }

    public function store(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data=[
                    'user_id'      => $_SESSION['user_id'],
                    'status_id'    => 1,
                    'address'      => $_POST['address'],
                    'phone'        => $_POST['phone'],
                    'total_amount' => $_POST['total_amount'],
                    'created_at'   => date('Y-m-d H:i:s'),
                    'note'         => $_POST['note'] ?? null
                ];
            $this->invoiceModel->insertInvoice($data);
        }
    }

    public function update(){
        $id=$_GET["invoice_id"] ?? null;
        if($id === null) return;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $status_id=$_POST["status_id"];
            $this->invoiceModel->updateStatus($status_id,$id);
        }
    }
}
?>
