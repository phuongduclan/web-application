<?php
require_once __DIR__ . '/DataProvider.php';

class User {
    /** View UV_ListAllUser — không phụ thuộc SP. */
    public function getAllUser() {
        return DataProvider::Instance()->ExecuteQuery(
            'SELECT * FROM UV_ListAllUser ORDER BY user_id'
        );
    }

    public function countAllUser() {
        return DataProvider::Instance()->ExecuteScalar('SELECT COUNT(*) FROM Account');
    }
}
