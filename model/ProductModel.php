<?php
class ProductModel extends BaseModel {
    // Table name form database.
    const TABLE ='Product';

    // Lấy tất cả danh sách sản phẩm
    public function getAllProduct()
    {
        return $this->getAll(self::TABLE);
    }
    // Lấy 1 dòng sản phẩm theo mã sản phẩm
    public function findByProductId($id)
    {
        return $this->findById(self::TABLE,$id);
    }
    // Thêm sản phẩm
    public function insertProduct($data)
    {
        $this->create(self::TABLE,$data);
    }
    public function updateProduct($id,$data)
    {
        $this->update(self::TABLE,$id,$data);
    }
    // Xóa sản phẩm
    public function deleteProduct($id){
        $this->delete(self::TABLE,$id);
    }
    // Lấy danh sách sản phẩm theo mã danh mục
    public function getAllProductByCategoryId($categoryId){
        $sql="SELECT * FROM " .self::TABLE. " WHERE category_id=?";
        return $this->executeQuery($sql,[$categoryId]);
    }
}
?>