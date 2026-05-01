<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$error = isset($error) ? $error : null;

$this->view('frontend.layouts.header', array(
    'pageTitle' => 'Đăng ký',
    'bodyClass' => 'login-page',
));

?>
<section class="login-section">
    <div class="container">
        <div class="login-wrapper">
            <div class="login-left">
                <h1>Tạo tài khoản</h1>
                <p>Đăng ký để quản lý đơn hàng thuận tiện hơn.</p>
                <img src="<?php echo htmlspecialchars(app_asset('images/banners/hero-banner.jpg')); ?>" alt="">
            </div>
            <div class="login-right">
                <h2>Đăng ký</h2>
<?php if (!empty($error)) { ?>
                <p style="color:red;"><?php echo htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
                <form method="post" action="<?php echo htmlspecialchars(app_route('auth', 'register')); ?>" class="login-form">
                    <div class="form-group">
                        <label for="reg_email">Email</label>
                        <input type="email" id="reg_email" name="email" required autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="reg_password">Mật khẩu (tối thiểu 8 ký tự)</label>
                        <input type="password" id="reg_password" name="password" required minlength="8" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label for="reg_confirm">Xác nhận mật khẩu</label>
                        <input type="password" id="reg_confirm" name="confirmPassword" required minlength="8" autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn cart-cta">Đăng ký</button>
                </form>
                <p style="margin-top:1rem;"><a href="<?php echo htmlspecialchars(app_route('auth', 'login')); ?>">Đã có tài khoản? Đăng nhập</a></p>
            </div>
        </div>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
