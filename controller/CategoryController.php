<?php
class CategoryController extends BaseController {
    private $categoryModel;
    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->loadModel('CategoryModel');
        $this->categoryModel= new CategoryModel();
        $this->productModel= new ProductModel();
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
        $id = $_GET['id'] ?? null;

        $category = $this->categoryModel->findByCategoryId($id);
        $products = $this->productModel->getAllProductByCategoryId($id);

        return $this->view('frontend.categories.show', [
            'category' => $category,
            'products' => $products
        ]);
    }
    public function store(){
        $data=[];
        $this->categoryModel->insertCategory($data);
    }
    public function update(){
        $id=$_GET['id'];
        $data=[];
        $this->categoryModel->updateCategory($id,$data);
    }
    public function delete()
    {
        $id=$_GET['id'];
        $this->categoryModel->deleteCategory($id);
    }
}