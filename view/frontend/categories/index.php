<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh mục</title>
</head>
<body>
<p><a href="index.php?controller=home">Trang chủ</a> | <a href="index.php?controller=product&amp;action=index">Sản phẩm</a> | <a href="index.php?controller=cart">Giỏ hàng</a></p>
<h1>Danh mục</h1>
<?php if(empty($categories)){ ?>
<p>Không có danh mục.</p>
<?php } else { ?>
<ul>
<?php foreach($categories as $c){ ?>
<li><a href="index.php?controller=category&amp;action=show&amp;id=<?php echo (int)($c['id'] ?? 0); ?>"><?php echo htmlspecialchars((string)($c['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></a></li>
<?php } ?>
</ul>
<?php } ?>
</body>
</html>
