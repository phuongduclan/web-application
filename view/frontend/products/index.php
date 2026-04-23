<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sản phẩm</title>
</head>
<body>
<p><a href="index.php?controller=home">Trang chủ</a> | <a href="index.php?controller=cart">Giỏ hàng</a></p>
<h1>Sản phẩm</h1>
<?php if(empty($products)){ ?>
<p>Không có sản phẩm.</p>
<?php } else { ?>
<ul>
<?php foreach($products as $p){ ?>
<li><a href="index.php?controller=product&amp;action=show&amp;product_id=<?php echo (int)($p['id'] ?? 0); ?>"><?php echo htmlspecialchars((string)($p['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></a></li>
<?php } ?>
</ul>
<?php } ?>
</body>
</html>
