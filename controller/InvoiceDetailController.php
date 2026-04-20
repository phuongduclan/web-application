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
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data=[

            ];
            $this->invoiceDetailModel->insertInvoiceDetail($data);
        }
    }
}
?>