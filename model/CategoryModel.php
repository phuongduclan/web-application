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
    public function insertCategory($data)
    {
        return $this->create(self::TABLE,$data);
    }
    public function updateCategory($id,$data)
    {
        return $this->update(self::TABLE,$id,$data);
    }
    public function deleteCategory($id){
        return $this->delete(self::TABLE,$id);
    }
    public function getCategoryForMenu()
    {
        $sql="SELECT id, name FROM ".self::TABLE." ORDER BY id";
        return $this->executeQuery($sql);
    }
}
?>