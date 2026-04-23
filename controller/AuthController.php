<?php
class AuthController extends BaseController {
    private $accountModel;

    public function __construct() {
        $this->loadModel('AccountModel');
        $this->accountModel=new AccountModel();
    }

    private function passwordCheck($plain, $stored){
        if($stored===null || $stored===''){
            return false;
        }
        if(password_verify((string)$plain, (string)$stored)){
            return true;
        }
        if(strncmp((string)$stored, '$2', 2)!==0 && hash_equals((string)$stored, (string)$plain)){
            return true;
        }
        return false;
    }

    private function redirectLogin(){
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    private function redirectRegister(){
        header('Location: index.php?controller=auth&action=register');
        exit;
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email    = $_POST['email']??null;
            $password = $_POST['password']??null;

            $user = $this->accountModel->findAccountByEmail($email);

            if ($user === null) {
                $_SESSION['error'] = 'User not found';
                $this->redirectLogin();
            }

            if (!$this->passwordCheck($password, $user['password'] ?? '')) {
                $_SESSION['error'] = 'Mật khẩu đăng nhập không đúng';
                $this->redirectLogin();
            }

            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role']  = $user['role_id'];
            $_SESSION['success']    = 'Đăng nhập thành công';
            header('Location: index.php?controller=product&action=index');
            exit;
        }
        $error = $_SESSION['error'] ?? null;
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['error'], $_SESSION['success']);
        return $this->view('frontend.auth.login', [
            'error' => $error,
            'success' => $success,
        ]);
    }

    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email    = $_POST['email']??null;
            $password = $_POST['password']??null;
            $confirmPassword = $_POST['confirmPassword']??null;
            $user= $this->accountModel->findAccountByEmail($email);
            if($password==$confirmPassword){
                if(strlen($password)>=8){
                    if(filter_var($email,FILTER_VALIDATE_EMAIL)!=false ){
                        if($user == null){
                            $data=[
                                'email'    => $email,
                                'password' => password_hash($password, PASSWORD_BCRYPT),
                                'role_id'  => 2
                            ];
                            $this->accountModel->register($data);
                            $_SESSION['success'] = 'Đăng ký thành công';
                            header('Location: index.php?controller=auth&action=login');
                            exit;
                        }
                        else{
                            $_SESSION['error'] = 'Email đăng ký đã tồn tại';
                            $this->redirectRegister();
                        }
                    }
                    else{
                        $_SESSION['error'] = 'Email đăng ký không hợp lệ';
                        $this->redirectRegister();
                    }
                }
                else {
                    $_SESSION['error'] = 'Mật khẩu cần ít nhất 8 kí tự';
                    $this->redirectRegister();
                }
            }
            else{
                $_SESSION['error'] = 'Mật khẩu nhập lại không đúng';
                $this->redirectRegister();
            }
        }
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        return $this->view('frontend.auth.register', [
            'error' => $error,
        ]);
    }

    public function logout() {
        unset($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['user_role']);
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    public function profile(){
        if(empty($_SESSION['user_id'])){
            $_SESSION['error']='Vui lòng đăng nhập.';
            $this->redirectLogin();
        }
        $account=$this->accountModel->findByAccountId((int)$_SESSION['user_id']);
        if(empty($account)){
            unset($_SESSION['user_id'],$_SESSION['user_email'],$_SESSION['user_role']);
            $this->redirectLogin();
        }
        $profileSuccess=$_SESSION['profile_success'] ?? null;
        unset($_SESSION['profile_success']);
        return $this->view('frontend.auth.profile',[
            'account'=>$account,
            'profile_success'=>$profileSuccess,
        ]);
    }

    public function changePassword(){
        if(empty($_SESSION['user_id'])){
            $_SESSION['error']='Vui lòng đăng nhập.';
            $this->redirectLogin();
        }
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $current=(string)($_POST['current_password'] ?? '');
            $new=(string)($_POST['new_password'] ?? '');
            $confirm=(string)($_POST['confirm_password'] ?? '');
            if(strlen($new)<8){
                $_SESSION['profile_error']='Mật khẩu mới cần ít nhất 8 ký tự.';
                header('Location: index.php?controller=auth&action=changePassword');
                exit;
            }
            if($new!==$confirm){
                $_SESSION['profile_error']='Mật khẩu xác nhận không khớp.';
                header('Location: index.php?controller=auth&action=changePassword');
                exit;
            }
            $account=$this->accountModel->findByAccountId((int)$_SESSION['user_id']);
            if(empty($account) || !$this->passwordCheck($current,$account['password'] ?? '')){
                $_SESSION['profile_error']='Mật khẩu hiện tại không đúng.';
                header('Location: index.php?controller=auth&action=changePassword');
                exit;
            }
            $hash=password_hash($new, PASSWORD_BCRYPT);
            $this->accountModel->updateAccountPassword((int)$_SESSION['user_id'],$hash);
            $_SESSION['profile_success']='Đã đổi mật khẩu.';
            header('Location: index.php?controller=auth&action=profile');
            exit;
        }
        $profileError=$_SESSION['profile_error'] ?? null;
        unset($_SESSION['profile_error']);
        return $this->view('frontend.auth.change_password',[
            'profileError'=>$profileError,
        ]);
    }
}
?>
