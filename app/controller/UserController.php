<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (User::login($email, $password)) {
            echo "Đăng nhập thành công";
        } else {
            echo "Sai email hoặc mật khẩu";
        }
    }
}