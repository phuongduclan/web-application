<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'pageTitle' => 'Đổi mật khẩu',
    'navActive' => 'shop',
));

$profileError = isset($profileError) ? $profileError : null;

?>
<section class="product-page">
    <div class="container">
        <div class="section-header">
            <h2>Đổi mật khẩu</h2>
            <p><a href="<?php echo htmlspecialchars(app_route('auth', 'profile')); ?>">← Tài khoản</a></p>
<?php if (!empty($profileError)) { ?>
            <p style="color:#c00;"><?php echo htmlspecialchars((string) $profileError, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
            <form method="post" action="<?php echo htmlspecialchars(app_route('auth', 'changePassword')); ?>" style="max-width:420px;display:flex;flex-direction:column;gap:.75rem;">
                <label>Mật khẩu hiện tại<br><input type="password" name="current_password" required autocomplete="current-password" style="width:100%;"></label>
                <label>Mật khẩu mới (≥ 8 ký tự)<br><input type="password" name="new_password" required minlength="8" autocomplete="new-password" style="width:100%;"></label>
                <label>Xác nhận mật khẩu mới<br><input type="password" name="confirm_password" required minlength="8" autocomplete="new-password" style="width:100%;"></label>
                <button type="submit" class="btn cart-cta">Lưu</button>
            </form>
        </div>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
