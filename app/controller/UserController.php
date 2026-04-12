<?php
require_once __DIR__ . '/../model/User.php';

class AuthController {
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (User::login($email, $password)) {
            return true;
        } else {
            return false;
        }
    }
    public function registerAccount() {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirmPassword'] ?? '';

    if ($password !== $confirm) {
        return false;
    }

    $result = User::register($email, $password);

    if ($result === true) {
        return true;
    } else {
        return false;
    }
}
}
