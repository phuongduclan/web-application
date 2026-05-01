<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => 'Tài khoản',
    'navActive' => '',
    'layoutExtraCss' => array('invoice.css'),
));

$profile_success = isset($profile_success) ? $profile_success : null;
$account = isset($account) && is_array($account) ? $account : array();
$email = (string) ($account['email'] ?? '');
$initial = $email !== '' ? mb_strtoupper(mb_substr($email, 0, 1, 'UTF-8'), 'UTF-8') : '?';

?>
<section class="iv-page">
    <div class="container">
        <div class="iv-head">
            <div>
                <p class="iv-eyebrow">Tài khoản</p>
                <h1>Thông tin của bạn</h1>
            </div>
            <p class="iv-crumb">
                <a href="<?php echo htmlspecialchars(app_route('home')); ?>">Trang chủ</a>
                · <span>Tài khoản</span>
            </p>
        </div>

<?php if (!empty($profile_success)) { ?>
        <p class="iv-flash" style="background:#ecfdf5;border-color:#a7f3d0;color:#047857;"><?php echo htmlspecialchars((string) $profile_success, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>

        <div class="iv-grid" style="grid-template-columns:minmax(0,1fr) minmax(0,1.4fr);">
            <div class="iv-card" style="text-align:center;">
                <div style="width:96px;height:96px;border-radius:50%;background:linear-gradient(135deg,#111,#444);color:#fff;font-size:2.4rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin:8px auto 16px;font-family:'Plus Jakarta Sans',sans-serif;">
                    <?php echo htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <p style="margin:0 0 4px;font-weight:600;font-size:1.05rem;color:#111;word-break:break-all;"><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
                <p style="margin:0;font-size:.85rem;color:#6b6b6b;">Khách hàng</p>
            </div>

            <div class="iv-card">
                <h3>Hành động</h3>
                <div style="display:flex;flex-direction:column;gap:10px;margin-top:6px;">
                    <a href="<?php echo htmlspecialchars(app_route('invoice')); ?>" style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border:1px solid #ececec;border-radius:12px;color:#111;font-weight:500;transition:all .15s ease;">
                        <span>Lịch sử đơn hàng</span>
                        <span style="color:#6b6b6b;">→</span>
                    </a>
                    <a href="<?php echo htmlspecialchars(app_route('cart')); ?>" style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border:1px solid #ececec;border-radius:12px;color:#111;font-weight:500;transition:all .15s ease;">
                        <span>Giỏ hàng hiện tại</span>
                        <span style="color:#6b6b6b;">→</span>
                    </a>
                    <a href="<?php echo htmlspecialchars(app_route('auth', 'changePassword')); ?>" style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border:1px solid #ececec;border-radius:12px;color:#111;font-weight:500;transition:all .15s ease;">
                        <span>Đổi mật khẩu</span>
                        <span style="color:#6b6b6b;">→</span>
                    </a>
                    <a href="<?php echo htmlspecialchars(app_route('auth', 'logout')); ?>" onclick="return confirm('Đăng xuất khỏi tài khoản?');" style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:#111;color:#fff;border-radius:12px;font-weight:600;transition:all .15s ease;margin-top:6px;">
                        <span>Đăng xuất</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
