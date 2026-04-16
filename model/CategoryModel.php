<?php
class CategoryModel extends BaseModel
{
    // Table name form database.
    const TABLE ='Category';

    public function getAllCategory()
    {
        return $this->getAll(self::TABLE);
    }

    public function findByCategoryId($id)
    {
        return $this->findById(self::TABLE,$id);
    }
    public function deleteCategory(){
        return __METHOD__;
    }
}
?>