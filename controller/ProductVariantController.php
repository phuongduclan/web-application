<?php
class ProductVariantController extends BaseController{
    private $productVariantModel;
    public function __construct()
    {
        $this->loadModel('ProductVariantModel');
        $this->productVariantModel=new ProductVariantModel();
    }
    public function index(){
        $productVariantList = $this->productVariantModel->getAllProductVariant();
        return $this->view('frontend.variants.index',[
            'productVariants' => $productVariantList
        ]);
    }
    public function store(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data=[
                'product_id' => $_POST['product_id'],
                'size'       => $_POST['size'],
                'price'      => $_POST['price'],
                'color'      => $_POST['color'],
                'image'      => $_POST['image']
            ];
            $this->productVariantModel->insertProductVariant($data);
        }
    }
    public function show(){
        $id=$_GET['product_id'] ?? null;
        if($id === null) return;
        $productVariant=$this->productVariantModel->findProductVariantByProductId($id);
        echo '<pre>';
        print_r($productVariant);
    }
    public function update(){
        $id=$_GET['variant_id'] ?? null;
        if($id === null) return;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data=[
                'size'  => $_POST['size'],
                'price' => $_POST['price'],
                'color' => $_POST['color'],
                'image' => $_POST['image']
            ];
            $this->productVariantModel->updateProductVariant($id,$data);
        }
    }
    public function delete()
    {
        $id=$_GET['id'] ?? null;
        if($id === null) return;
        $this->productVariantModel->deleteProductVariant($id);
    }
}
?>