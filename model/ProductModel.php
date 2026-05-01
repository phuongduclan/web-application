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

    /**
     * Sản phẩm theo danh mục + ảnh đại diện (ảnh một biến thể bất kỳ, thường id nhỏ nhất).
     * Tên/mô tả cấp Product giữ chung; chi tiết biến thể ở ProductVariant.
     */
    public function getAllProductByCategoryIdWithCoverImage($categoryId){
        $sql="SELECT p.*, (
            SELECT TOP 1 pv.image FROM ProductVariant pv WHERE pv.product_id = p.id ORDER BY pv.id
        ) AS cover_image FROM ".self::TABLE." p WHERE p.category_id = ? ORDER BY p.id";
        return $this->executeQuery($sql,[$categoryId]);
    }

    public function getAllProductWithCoverImage(){
        $sql="SELECT p.*, (
            SELECT TOP 1 pv.image FROM ProductVariant pv WHERE pv.product_id = p.id ORDER BY pv.id
        ) AS cover_image FROM ".self::TABLE." p ORDER BY p.id";
        return $this->executeQuery($sql);
    }

    /**
     * Tìm sản phẩm theo tên (LIKE) + ảnh đại diện. Trả về luôn cả tên danh mục để hiển thị.
     */
    public function searchProductsWithCoverImage($keyword){
        $kw = '%' . trim((string) $keyword) . '%';
        $sql = "SELECT p.*, c.name AS category_name, (
            SELECT TOP 1 pv.image FROM ProductVariant pv WHERE pv.product_id = p.id ORDER BY pv.id
        ) AS cover_image
        FROM ".self::TABLE." p
        LEFT JOIN Category c ON c.id = p.category_id
        WHERE p.name LIKE ? OR c.name LIKE ?
        ORDER BY p.id";
        return $this->executeQuery($sql, array($kw, $kw));
    }
}
?>