<?php
class InvoiceDetailModel extends BaseModel {
    // Table name form database.
    const TABLE ='InvoiceDetail';

    public function getInvoiceDetailByInvoiceId($invoiceId){
        $sql="SELECT * FROM " .self::TABLE. " WHERE invoice_id=?";
        return $this->executeQuery($sql,[$invoiceId]);
    }
    public function insertInvoiceDetail($data){
        $this->create(self::TABLE,$data);
    }
}
?>