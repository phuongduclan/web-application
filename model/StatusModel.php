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
}
?>