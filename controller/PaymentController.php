<?php
class PaymentController extends BaseController{
    private $paymentModel;
    public function __construct(){
        $this->loadModel('PaymentModel');
        $this->paymentModel=new PaymentModel();
    }
    public function show(){
        $id=$_GET['invoice_id'] ?? null;
        if($id === null) return;
        $payment=$this->paymentModel->findPaymentByInvoiceId($id);
        echo '<pre>';
        print_r($payment);
    }
    public function store(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data=[
                'invoice_id'     => $_POST['invoice_id'],
                'method_id'      => $_POST['method_id'],
                'payment_date'   => date('Y-m-d'),
                'payment_amount' => $_POST['payment_amount']
            ];
            $this->paymentModel->insertPayment($data);
        }
    }
}
?>