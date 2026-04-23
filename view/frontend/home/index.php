<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ</title>
</head>
<body>
<h1>Trang chủ</h1>
<p>
<?php if(!empty($logged_in)){ ?>
Đã đăng nhập: <?php echo htmlspecialchars((string)($user_email ?? ''), ENT_QUOTES, 'UTF-8'); ?>
 | <a href="index.php?controller=auth&amp;action=profile">Tài khoản</a>
 | <a href="index.php?controller=auth&amp;action=logout">Đăng xuất</a>
<?php } else { ?>
<a href="index.php?controller=auth&amp;action=login">Đăng nhập</a>
 | <a href="index.php?controller=auth&amp;action=register">Đăng ký</a>
<?php } ?>
</p>
<p><a href="index.php?controller=category&amp;action=index">Danh mục</a>
 | <a href="index.php?controller=product&amp;action=index">Sản phẩm</a>
 | <a href="index.php?controller=cart">Giỏ hàng</a>
 | <a href="index.php?controller=invoice&amp;action=index">Đơn hàng</a></p>
<?php if(!empty($categories)){ ?>
<h2>Danh mục</h2>
<ul>
<?php foreach($categories as $c){ ?>
<li><a href="index.php?controller=category&amp;action=show&amp;id=<?php echo (int)($c['id'] ?? 0); ?>"><?php echo htmlspecialchars((string)($c['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></a></li>
<?php } ?>
</ul>
<?php } ?>
</body>
</html>
