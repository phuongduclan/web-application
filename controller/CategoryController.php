<?php
class CategoryController extends BaseController {
    private $categoryModel;
    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->categoryModel= new CategoryModel();
    }
    public function index()
    {
        $categoryList=$this->categoryModel->getAll();
        return $this->view('frontend.categories.index',[
            'categories' => $categoryList
        ]);
    }
    public function store()
    {
        echo __METHOD__;
    }
}