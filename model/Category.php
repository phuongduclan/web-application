<?php
require_once __DIR__ . '/DataProvider.php';

class Category {
    public function getAll() {
        $rows = DataProvider::Instance()->ExecuteQuery('EXEC USP_GetAllCategory');
        usort($rows, static function ($a, $b) {
            return ((int) ($a['category_id'] ?? 0)) <=> ((int) ($b['category_id'] ?? 0));
        });
        return $rows;
    }

    public function getById($categoryId) {
        // Script DB không có USP_GetCategoryById — lấy theo khóa chính.
        return DataProvider::Instance()->ExecuteQuery(
            'SELECT category_id, category_name FROM Category WHERE category_id = ?',
            [(int) $categoryId]
        );
    }

    public function add($categoryName) {
        return DataProvider::Instance()->ExecuteNonQuery(
            'EXEC USP_InsertCategory @CategoryName = ?',
            [trim((string) $categoryName)]
        );
    }

    public function update($categoryId, $categoryName) {
        return DataProvider::Instance()->ExecuteNonQuery(
            'UPDATE Category SET category_name = ? WHERE category_id = ?',
            [trim((string) $categoryName), (int) $categoryId]
        );
    }

    public function delete($categoryId) {
        return DataProvider::Instance()->ExecuteNonQuery(
            'DELETE FROM Category WHERE category_id = ?',
            [(int) $categoryId]
        );
    }
}
