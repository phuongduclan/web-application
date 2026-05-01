<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'pageTitle' => 'Tài khoản',
    'navActive' => 'shop',
));

$profile_success = isset($profile_success) ? $profile_success : null;
$account = isset($account) && is_array($account) ? $account : array();

?>
<section class="product-page">
    <div class="container">
        <div class="section-header">
            <h2>Thông tin tài khoản</h2>
<?php if (!empty($profile_success)) { ?>
            <p style="color:green;"><?php echo htmlspecialchars((string) $profile_success, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
            <p><strong>Email:</strong> <?php echo htmlspecialchars((string) ($account['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
            <p>Họ tên, địa chỉ: có thể bổ sung khi mở rộng schema người dùng.</p>
            <p><a href="<?php echo htmlspecialchars(app_route('auth', 'changePassword')); ?>" class="btn btn-outline">Đổi mật khẩu</a></p>
        </div>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
