
<?php
require_once __DIR__ . '/../core/DataProvider.php';

class User {
    public static function login($email, $password) {
        $query = "EXEC USP_Login @Email = :email, @Password = :password";

        $params = [
            ':email' => $email,
            ':password' => $password
        ];

        $result = DataProvider::Instance()->ExecuteQuery($query, $params);

        return count($result) > 0;
    }
}