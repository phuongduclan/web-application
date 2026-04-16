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
    public function updateProduct()
    {
        
    }
    // Xóa sản phẩm
    public function deleteProduct(){
        return __METHOD__;
    }
}
?>