<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tài khoản</title>
</head>
<body>
<h1>Thông tin tài khoản</h1>
<p><a href="index.php?controller=home">Trang chủ</a></p>
<?php if(!empty($profile_success)){ ?>
<p><?php echo htmlspecialchars((string)$profile_success, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<p><strong>Email:</strong> <?php echo htmlspecialchars((string)($account['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
<p>Họ tên, địa chỉ, số điện thoại: chưa có cột trong bảng Account theo schema hiện tại.</p>
<p><a href="index.php?controller=auth&amp;action=changePassword">Đổi mật khẩu</a></p>
</body>
</html>
