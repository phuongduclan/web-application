<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
</head>
<body>
<h1>Đổi mật khẩu</h1>
<p><a href="index.php?controller=auth&amp;action=profile">Tài khoản</a> | <a href="index.php?controller=home">Trang chủ</a></p>
<?php if(!empty($profileError)){ ?>
<p><?php echo htmlspecialchars((string)$profileError, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<form method="post" action="index.php?controller=auth&amp;action=changePassword">
<p><label>Mật khẩu hiện tại<br><input type="password" name="current_password" required autocomplete="current-password"></label></p>
<p><label>Mật khẩu mới (tối thiểu 8 ký tự)<br><input type="password" name="new_password" required minlength="8" autocomplete="new-password"></label></p>
<p><label>Xác nhận mật khẩu mới<br><input type="password" name="confirm_password" required minlength="8" autocomplete="new-password"></label></p>
<p><button type="submit">Lưu</button></p>
</form>
</body>
</html>
