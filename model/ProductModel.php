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
        return __METHOD__;
    }
    // Xóa sản phẩm
    public function delete(){
        return __METHOD__;
    }
}
?>