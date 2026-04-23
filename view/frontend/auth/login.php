<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>
<h1>Đăng nhập</h1>
<p><a href="index.php?controller=home">Trang chủ</a> | <a href="index.php?controller=auth&amp;action=register">Đăng ký</a></p>
<?php if(!empty($error)){ ?>
<p><?php echo htmlspecialchars((string)$error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<?php if(!empty($success)){ ?>
<p><?php echo htmlspecialchars((string)$success, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<form method="post" action="index.php?controller=auth&amp;action=login">
<p><label>Email<br><input type="email" name="email" required autocomplete="email"></label></p>
<p><label>Mật khẩu<br><input type="password" name="password" required autocomplete="current-password"></label></p>
<p><button type="submit">Đăng nhập</button></p>
</form>
</body>
</html>
