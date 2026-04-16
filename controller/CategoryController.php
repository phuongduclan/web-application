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
        $categoryList = $this->categoryModel->getAllCategory();
        return $this->view('frontend.categories.index',[
            'categories' => $categoryList
        ]);
    }
    public function show()
    {
        $id=$_GET['id'];
        $category=$this->categoryModel->findByCategoryId($id);
        echo '<pre>';
        print_r($category);
    }
}