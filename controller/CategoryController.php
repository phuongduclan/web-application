<?php

class CategoryController extends BaseController {
    public function index(){
        return $this->view('frontend.categories.index');
    }
    public function store(){
        echo __METHOD__;
    }
}