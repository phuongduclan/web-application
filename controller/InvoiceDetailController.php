<?php
class InvoiceDetailController extends BaseController{
    private $invoiceDetailModel;
    public function __construct(){
        $this->loadModel('InvoiceDetailModel');
        $this->invoiceDetailModel=new InvoiceDetailModel();
    }
    public function show(){
        $id=$_GET['invoice_id']??null;
        if($id === null) return;
        $invoiceDetails=$this->invoiceDetailModel->getInvoiceDetailByInvoiceId($id);
        echo '<pre>';
        print_r($invoiceDetails);
    }
    public function store(){
        $id=$_GET['invoice_id']??null;
        if($id===null)return;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data=[
                'variant_id' => $_POST['variant_id'],
                'invoice_id' => $id,
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity']
            ];
            $this->invoiceDetailModel->insertInvoiceDetail($data);
        }
    }
}
?>