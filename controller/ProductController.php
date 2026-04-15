<?php

class ProductController extends BaseController{
    private $productModel;
    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel=new ProductModel();
    }
    public function index(){
        $productList=$this->productModel->getAll();
        return $this->view('frontend.products.index',[
            'products'=> $productList
        ]);
    }

    public function show(){
        echo __METHOD__;
    }
}

?>