<?php

class CartController extends BaseController {
    protected $productVariantModel;
    public function __construct(){
        $this->loadModel('ProductVariantModel');
        $this->productVariantModel=new ProductVariantModel;
    }
    public function index(){
        return $this->view('frontend.carts.index');
    }

    public function show(){
        echo __METHOD__;
    }
    // Thêm sản phẩm vào giỏ hàng
    public function store(){
        $variantId= $_GET['variant_id']??null;
        $productVariant=$this->productVariantModel->findByProductVariantId($variantId);
        // Tạo biến Global Session $_SESSION['cart'][$productId]=$product;
        // Cú pháp array_key_exists($key, $array)
        if(empty($_SESSION['cart'])|| ! array_key_exists($variantId, $_SESSION['cart'])){
            $productVariant['qty']=1;
            $_SESSION['cart'][$variantId]=$productVariant;
        }
        else{
            $productVariant['qty'] = $_SESSION['cart'][$variantId]['qty']+1;
            $_SESSION['cart'][$variantId]=$productVariant;
        }
        // Thực hiện chuyển đến trang giỏ hàng
        header('location:index.php?controller=cart');
    }

    public function update(){
        $id=$_GET['variant_id']??null;
        if($id===null)return;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $quantity=$_POST['quantity']??0;
            if($quantity==0){return;}
            $_SESSION['cart'][$id]['qty'] = $quantity;
            header('location:index.php?controller=cart');
        }
    }
    public function destroy(){
        $id=$_GET['variant_id']??null;
        if($id===null)return;
        unset($_SESSION['cart'][$id]);
        header('location:index.php?controller=cart');
    }
}