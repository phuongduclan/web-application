<?php
private $accountModel;
{
    public function __construct() {
        $this->loadModel('AccountModel');
        $this->accountModel=new AccountModel();
    }
    public function login(){
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $user= $this->accountModel->findAccountByEmail($email);
        if($user!=null){
            if(password_verify($password,$user['password'])!=false){
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role']  = $user['role_id'];
                $_SESSION['success'] = 'Đăng nhập thành công';
            }
            else{
                $_SESSION['error'] = 'Mật khẩu đăng nhập không đúng';
                return;
            }
        }
        else{
            $_SESSION['error'] = 'User not found';
            return;
        }
    }

    public function register() {
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $user= $this->accountModel->findAccountByEmail($email);
        if($password==$confirmPassword){
            if(strlen($password)>=8){
                // Kiểm tra email hợp lệ
                if(filter_var($email,FILTER_VALIDATE_EMAIL)!=false ){
                    if($user == null){
                        $data=[
                            'email'    => $email,
                            'password' => $password,
                            'role_id'  => 2
                        ];
                        $this->accountModel->register($data);
                        $_SESSION['success'] = 'Đăng ký thành công';
                    }
                    else{
                        $_SESSION['error'] = 'Email đăng ký đã tồn tại';
                        return;
                    }
                }
                else{
                    $_SESSION['error'] = 'Email đăng ký không hợp lệ';
                    return;
                }
            }
            else {
                $_SESSION['error'] = 'Mật khẩu cần ít nhất 8 kí tự';
                return;
            }
        }
        else{
            $_SESSION['error'] = 'Mật khẩu nhập lại không đúng';
            return;
        }
    }

    public function logout() {
        session_destroy();
    }
}
?>