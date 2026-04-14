<?php
require_once __DIR__ . '/DataProvider.php';

/**
 * Sản phẩm / biến thể khớp DB web_app: USP_GetAllProduct, USP_InsertProduct, …;
 * cập nhật sản phẩm = UPDATE Product (không có USP_UpdateProduct);
 * cập nhật biến thể = UPDATE ProductVariant (không có USP_UpdateVariant).
 */
class Product {
    public function getCategories() {
        $rows = DataProvider::Instance()->ExecuteQuery('EXEC USP_GetAllCategory');
        usort($rows, static function ($a, $b) {
            return strcmp((string) ($a['category_name'] ?? ''), (string) ($b['category_name'] ?? ''));
        });
        return $rows;
    }

    public function getAllProduct() {
        return DataProvider::Instance()->ExecuteQuery('EXEC USP_GetAllProduct');
    }

    public function getProductById($productId) {
        return DataProvider::Instance()->ExecuteQuery(
            'EXEC USP_GetProductById @productId = ?',
            [(int) $productId]
        );
    }

    public function addProduct($productName, $categoryId) {
        $cat = ($categoryId !== null && (int) $categoryId > 0) ? (int) $categoryId : null;
        return DataProvider::Instance()->ExecuteNonQuery(
            'EXEC USP_InsertProduct @ProductName = ?, @CategoryId = ?',
            [$productName, $cat]
        );
    }

    public function updateProduct($productId, $productName, $categoryId) {
        $cat = ($categoryId !== null && (int) $categoryId > 0) ? (int) $categoryId : null;
        // Script DB không có USP_UpdateProduct — cập nhật trực tiếp bảng Product.
        return DataProvider::Instance()->ExecuteNonQuery(
            'UPDATE Product SET product_name = ?, category_id = ? WHERE product_id = ?',
            [$productName, $cat, (int) $productId]
        );
    }

    public function deleteProduct($productId) {
        return DataProvider::Instance()->ExecuteNonQuery(
            'EXEC USP_DeleteProduct @ProductId = ?',
            [(int) $productId]
        );
    }

    public function addVarient($productId, $size, $color, $price, $imageUrl) {
        return DataProvider::Instance()->ExecuteNonQuery(
            'EXEC USP_InsertVariant @productId = ?, @Size = ?, @Color = ?, @Price = ?, @Image = ?',
            [
                (int) $productId,
                $size,
                $color,
                (int) round((float) $price),
                $imageUrl !== '' ? $imageUrl : null,
            ]
        );
    }

    public function updateVarient($varientId, $size, $color, $price, $imageUrl) {
        return DataProvider::Instance()->ExecuteNonQuery(
            'UPDATE ProductVariant SET size = ?, color = ?, price = ?, image = ? WHERE variant_id = ?',
            [
                $size,
                $color,
                (int) round((float) $price),
                $imageUrl !== '' ? $imageUrl : null,
                (int) $varientId,
            ]
        );
    }

    public function deleteVarient($varientId) {
        return DataProvider::Instance()->ExecuteNonQuery(
            'EXEC USP_DeleteVariant @VariantId = ?',
            [(int) $varientId]
        );
    }

    public function getVarientByProductId($productId) {
        return DataProvider::Instance()->ExecuteQuery(
            'EXEC USP_GetVariantByProductId @productId = ?',
            [(int) $productId]
        );
    }
}
