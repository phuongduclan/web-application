<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$error = isset($error) ? $error : null;
$success = isset($success) ? $success : null;

$this->view('frontend.layouts.header', array(
    'pageTitle' => 'Đăng nhập',
    'bodyClass' => 'login-page',
));

?>
<section class="login-section">
    <div class="container">
        <div class="login-wrapper">
            <div class="login-left">
                <h1>Chào mừng trở lại</h1>
                <p>Đăng nhập để tiếp tục mua sắm và thanh toán.</p>
                <img src="<?php echo htmlspecialchars(app_asset('images/banners/hero-banner.jpg')); ?>" alt="">
            </div>
            <div class="login-right">
                <h2>Đăng nhập</h2>
<?php if (!empty($error)) { ?>
                <p style="color:red;"><?php echo htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } elseif (!empty($success)) { ?>
                <p style="color:green;"><?php echo htmlspecialchars((string) $success, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
                <form method="post" action="<?php echo htmlspecialchars(app_route('auth', 'login')); ?>" class="login-form">
                    <div class="form-group">
                        <label for="login_email">Email</label>
                        <input type="email" id="login_email" name="email" required autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="login_password">Mật khẩu</label>
                        <input type="password" id="login_password" name="password" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn cart-cta">Đăng nhập</button>
                </form>
                <p style="margin-top:1rem;"><a href="<?php echo htmlspecialchars(app_route('auth', 'register')); ?>">Chưa có tài khoản? Đăng ký</a></p>
            </div>
        </div>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
