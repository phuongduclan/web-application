<?php
class PaymentModel extends BaseModel{
    // Table name form database.
    const TABLE ='Payment';

    public function insertPayment($data){
        return $this->create(self::TABLE,$data);
    }
    public function findPaymentByInvoiceId($invoiceId)
    {
        $sql="SELECT * FROM " .self::TABLE. " WHERE invoice_id=?";
        return $this->executeQuery($sql,[$invoiceId]);
    }
}
?>