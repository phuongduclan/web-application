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
        $categoriesMenu =$this->categoryModel->getCategoryForMenu();
        $category = $this->categoryModel->findByCategoryId($id);
        $products = $this->productModel->getAllProductByCategoryIdWithCoverImage($id);

        return $this->view('frontend.categories.show', [
            'menus'    => $categoriesMenu,
            'category' => $category,
            'products' => $products
        ]);
    }
    public function store(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data=[
                'name' => $_POST['name'] ?? ''
            ];
            $this->categoryModel->insertCategory($data);
        }
    }
    public function update(){
        $id=$_GET['category_id'] ?? null;
        if($id === null) return;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data=[
                'name' => $_POST['name'] ??null
            ];
            $this->categoryModel->updateCategory($id,$data);
        }
    }
    public function delete()
    {
        $id=$_GET['id'] ?? null;
        if($id === null) return;
        $this->categoryModel->deleteCategory($id);
    }
}