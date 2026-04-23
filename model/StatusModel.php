<?php
class StatusModel extends BaseModel{
    // Table name form database.
    const TABLE ='Status';

    public function getAllStatus()
    {
        return $this->getAll(self::TABLE);
    }
    public function findByStatusId($id)
    {
        return $this->findById(self::TABLE,$id);
    }

    public function findFirstByStatusName($name){
        $sql='SELECT TOP 1 * FROM '.self::TABLE.' WHERE name = ?';
        $stmt=$this->connect->prepare($sql);
        $stmt->execute([$name]);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row===false ? null : $row;
    }
}
?>