<?php
class InvoiceController extends BaseController{
    private $invoiceModel;
    public function __construct()
    {
        $this->loadModel('InvoiceModel');
        $this->invoiceModel=new InvoiceModel();
    }
    public function index(){
        $invoiceList=$this->invoiceModel->getAllInvoice();
        return $this->view('frontend.invoices.index',[
            'invoices'=> $invoiceList
        ]);
    }
    public function show(){
        $id=$_GET['user_id'] ?? null;
        if($id === null) return;
        $invoice=$this->invoiceModel->getInvoiceByUserId($id);
        echo '<pre>';
        print_r($invoice);
    }
    public function store(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data=[
                    'user_id'      => $_SESSION['user_id'], 
                    'status_id'    => 1,  
                    'address'      => $_POST['address'],
                    'phone'        => $_POST['phone'],
                    'total_amount' => $_POST['total_amount'], 
                    'created_at'   => date('Y-m-d H:i:s'),   
                    'note'         => $_POST['note'] ?? null
                ];
            $this->invoiceModel->insertInvoice($data);
        }
    }
    public function update(){
        $id=$_GET["invoice_id"] ?? null;
        if($id === null) return;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $status_id=$_POST["status_id"];
            $this->invoiceModel->updateStatus($status_id,$id);
        }
    }
}
?>