<?php

class ProductController extends BaseController{
    private $productModel;
    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel=new ProductModel();
    }
    
    public function index(){
        $q = isset($_GET['q']) ? trim((string) $_GET['q']) : '';
        if ($q !== '') {
            $productList = $this->productModel->searchProductsWithCoverImage($q);
        } else {
            $productList = $this->productModel->getAllProductWithCoverImage();
        }
        $this->loadModel('CategoryModel');
        $categoryModel=new CategoryModel();
        return $this->view('frontend.products.index',[
            'products'    => $productList,
            'menus'       => $categoryModel->getCategoryForMenu(),
            'searchQuery' => $q,
        ]);
    }
    public function store(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data=[
                'name'        => $_POST['name']??null,
                'category_id' => $_POST['category_id']??null,
            ];
            $this->productModel->insertProduct($data);
        }
    }
    public function show(){
        $id=$_GET['product_id'] ?? $_GET['id'] ?? null;
        if($id===null){
            header('Location: index.php?controller=product&action=index');
            exit;
        }
        $product=$this->productModel->findByProductId($id);
        if(empty($product)){
            header('Location: index.php?controller=product&action=index');
            exit;
        }
        $this->loadModel('ProductVariantModel');
        $productVariantModel=new ProductVariantModel();
        $variants=$productVariantModel->findProductVariantByProductId($id);
        $this->loadModel('CategoryModel');
        $categoryModel=new CategoryModel();
        return $this->view('frontend.products.show',[
            'product'=>$product,
            'variants'=>$variants,
            'menus'=>$categoryModel->getCategoryForMenu(),
        ]);
    }
    public function update(){
        $id=$_GET['id'] ?? null;
        if($id === null) return;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data=[
                'name'        => $_POST['name'],
                'category_id' => $_POST['category_id']
            ];
            $this->productModel->updateProduct($id,$data);
        }
    }
    public function delete()
    {
        $id=$_GET['id'] ?? null;
        if($id === null) return;
        $this->productModel->deleteProduct($id);
    }
}

?>