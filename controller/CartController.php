<?php

class CartController extends BaseController {
    public function index(){
        return $this->view('frontend.carts.index');
    }

    public function show(){
        echo __METHOD__;
    }

    public function create(){
        echo __METHOD__;
    }

    public function store(){
        echo __METHOD__;
    }

    public function edit(){
        echo __METHOD__;
    }

    public function update(){
        echo __METHOD__;
    }

    public function destroy(){
        echo __METHOD__;
    }
}