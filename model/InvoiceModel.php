<?php
class InvoiceModel extends BaseModel{
    // Table name form database.
    const TABLE ='Invoice';

    public function getAllInvoice(){
        return $this->getAll(self::TABLE);
    }
    public function getInvoiceByUserId($userId)
    {
        $sql="SELECT * FROM " .self::TABLE. " WHERE user_id=?";
        return $this->executeQuery($sql,[$userId]);
    }

    public function getInvoicesForUserWithStatus($userId){
        $sql='SELECT i.*, s.name AS status_name FROM '.self::TABLE.' i LEFT JOIN Status s ON s.id=i.status_id WHERE i.user_id=? ORDER BY i.id DESC';
        return $this->executeQuery($sql,[$userId]);
    }
    public function insertInvoice($data)
    {
        return $this->create(self::TABLE,$data);
    }

    public function findByInvoiceId($id){
        return $this->findById(self::TABLE,$id);
    }

    public function insertInvoiceReturnId(array $data){
        $this->create(self::TABLE,$data);
        $stmt=$this->connect->query('SELECT CAST(SCOPE_IDENTITY() AS INT) AS new_id');
        if($stmt){
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($row['new_id'])){
                return (int)$row['new_id'];
            }
        }
        $lid=$this->connect->lastInsertId();
        return $lid!==false && $lid!=='' ? (int)$lid : 0;
    }
    public function updateStatus($statusId,$id)
    {
        $sql="UPDATE ".self::TABLE." SET status_id= ? WHERE id= ? ";
        return $this->executeNonQuery($sql,[$statusId,$id]);
    }
}
?>