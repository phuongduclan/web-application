<?php

class ProductController extends BaseController{
    private $productModel;
    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel=new ProductModel();
    }
    
    public function index(){
        $productList=$this->productModel->getAllProduct();
        return $this->view('frontend.products.index',[
            'products'=> $productList
        ]);
    }
    public function store(){
        $data=[];
        $this->productModel->insertProduct($data);
    }
    public function show(){
        $id=$_GET['id'];
        $product=$this->productModel->findByProductId($id);
        echo '<pre>';
        print_r($product);
    }
    public function update(){
        $id=$_GET['id'];
        $data=[];
        $this->productModel->updateProduct($id,$data);
    }
    public function delete()
    {
        $id=$_GET['id'];
        $this->productModel->deleteProduct($id);
    }
}

?>