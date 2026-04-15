<?php
class CategoryModel extends BaseModel
{
    // Table name form database.
    const TABLE ='Category';

    public function getAllCategory()
    {
        return $this->getAll(self::TABLE);
    }

    public function findById($id)
    {
        return __METHOD__;
    }
    public function delete(){
        return __METHOD__;
    }
}
?>