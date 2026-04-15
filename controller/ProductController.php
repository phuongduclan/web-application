<?php

class ProductController extends BaseController{
    public function index(){
        return $this->view('frontend.products.index',);
    }

    public function show(){
        echo __METHOD__;
    }
}

?>