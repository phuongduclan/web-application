<?php
class ProductVariantModel extends BaseModel{
    // Table name form database.
    const TABLE ='ProductVariant';

    public function findProductVariantByProductId($productId){
        $sql="SELECT * FROM " .self::TABLE. " WHERE product_id=?";
        return $this->executeQuery($sql,[$productId]);
    }
    public function insertProductVariant($data){
        return $this->create(self::TABLE,$data);
    }
    public function updateProductVariant($id, $data){
        return $this->update(self::TABLE,$id,$data);
    }
    public function deleteProductVariant($id){
        return $this->delete(self::TABLE,$id);
    }
}
?>