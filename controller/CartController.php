<?php

class CartController extends BaseController {
    protected $productVariantModel;

    public function __construct(){
        $this->loadModel('ProductVariantModel');
        $this->productVariantModel=new ProductVariantModel;
    }

    private function ensureCartSession(){
        if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])){
            $_SESSION['cart']=[];
        }
    }

    private function variantKey($variantId){
        if($variantId===null || $variantId===''){
            return null;
        }
        return (string)$variantId;
    }

    public function index(){
        $this->ensureCartSession();
        $cartError=$_SESSION['cart_error'] ?? null;
        unset($_SESSION['cart_error']);
        $cartTotal=0;
        foreach($_SESSION['cart'] as $line){
            $cartTotal+=(int)($line['price'] ?? 0)*(int)($line['qty'] ?? 0);
        }
        return $this->view('frontend.carts.index',[
            'cart'=>$_SESSION['cart'],
            'cartTotal'=>$cartTotal,
            'cartError'=>$cartError,
            'logged_in'=>!empty($_SESSION['user_id']),
        ]);
    }

    public function show(){
        echo __METHOD__;
    }

    public function store(){
        $this->ensureCartSession();
        $key=$this->variantKey($_POST['variant_id'] ?? $_GET['variant_id'] ?? null);
        $qtyAdd=(int)($_POST['quantity'] ?? $_GET['quantity'] ?? 1);
        if($qtyAdd<1){
            $qtyAdd=1;
        }
        if($key===null){
            $_SESSION['cart_error']='Chưa chọn biến thể sản phẩm.';
            header('Location: index.php?controller=cart');
            exit;
        }
        $row=$this->productVariantModel->findByProductVariantId($key);
        if($row===false || empty($row)){
            $_SESSION['cart_error']='Không tìm thấy biến thể sản phẩm.';
            header('Location: index.php?controller=cart');
            exit;
        }
        $this->loadModel('ProductModel');
        $productModel=new ProductModel();
        $product=$productModel->findByProductId($row['product_id']);
        $row['product_name']=$product['name'] ?? '';
        if(array_key_exists($key,$_SESSION['cart'])){
            $_SESSION['cart'][$key]['qty']=(int)$_SESSION['cart'][$key]['qty']+$qtyAdd;
        }else{
            $row['qty']=$qtyAdd;
            $_SESSION['cart'][$key]=$row;
        }
        header('Location: index.php?controller=cart');
        exit;
    }

    public function update(){
        $this->ensureCartSession();
        $key=$this->variantKey($_GET['variant_id'] ?? null);
        if($key===null || !array_key_exists($key,$_SESSION['cart'])){
            header('Location: index.php?controller=cart');
            exit;
        }
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            header('Location: index.php?controller=cart');
            exit;
        }
        $quantity=(int)($_POST['quantity'] ?? 1);
        if($quantity<1){
            $quantity=1;
        }
        $_SESSION['cart'][$key]['qty']=$quantity;
        header('Location: index.php?controller=cart');
        exit;
    }

    public function destroy(){
        $this->ensureCartSession();
        $key=$this->variantKey($_GET['variant_id'] ?? null);
        if($key===null){
            header('Location: index.php?controller=cart');
            exit;
        }
        unset($_SESSION['cart'][$key]);
        header('Location: index.php?controller=cart');
        exit;
    }
}
?>
