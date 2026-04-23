<?php
class HomeController extends BaseController{
    private $categoryModel;

    public function __construct(){
        $this->loadModel('CategoryModel');
        $this->categoryModel=new CategoryModel();
    }

    public function index(){
        $categories=$this->categoryModel->getAllCategory();
        return $this->view('frontend.home.index',[
            'categories'=>$categories,
            'user_email'=>$_SESSION['user_email'] ?? '',
            'logged_in'=>!empty($_SESSION['user_id']),
        ]);
    }
}
?>
