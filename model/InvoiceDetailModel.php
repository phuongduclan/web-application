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

    public function getRowsWithProductForInvoice($invoiceId){
        $sql='SELECT d.id, d.variant_id, d.invoice_id, d.price, d.quantity, pv.size, pv.color, pv.image, p.name AS product_name
            FROM '.self::TABLE.' d
            INNER JOIN ProductVariant pv ON pv.id = d.variant_id
            INNER JOIN Product p ON p.id = pv.product_id
            WHERE d.invoice_id = ?';
        return $this->executeQuery($sql,[$invoiceId]);
    }
}
?>