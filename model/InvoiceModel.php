<?php
class InvoiceModel extends BaseModel{
    // Table name form database.
    const TABLE ='Invoice';

    public function getInvoiceByUserId($userId)
    {
        $sql="SELECT * FROM " .self::TABLE. " WHERE user_id=?";
        return $this->executeQuery($sql,[$userId]);
    }
    public function insertInvoice($data)
    {
        return $this->create(self::TABLE,$data);
    }
    public function updateStatus($statusId,$id)
    {
        $sql="UPDATE ".self::TABLE." SET status_id= ? WHERE id= ? ";
        return $this->executeNonQuery($sql,[$statusId,$id]);
    }
}
?>