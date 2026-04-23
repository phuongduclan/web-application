<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
</head>
<body>
<h1>Đăng ký</h1>
<p><a href="index.php?controller=home">Trang chủ</a> | <a href="index.php?controller=auth&amp;action=login">Đăng nhập</a></p>
<?php if(!empty($error)){ ?>
<p><?php echo htmlspecialchars((string)$error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<form method="post" action="index.php?controller=auth&amp;action=register">
<p><label>Email<br><input type="email" name="email" required autocomplete="email"></label></p>
<p><label>Mật khẩu (tối thiểu 8 ký tự)<br><input type="password" name="password" required minlength="8" autocomplete="new-password"></label></p>
<p><label>Xác nhận mật khẩu<br><input type="password" name="confirmPassword" required minlength="8" autocomplete="new-password"></label></p>
<p><button type="submit">Đăng ký</button></p>
</form>
</body>
</html>
