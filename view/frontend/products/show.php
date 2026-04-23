<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars((string)($product['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></title>
</head>
<body>
<p><a href="index.php?controller=home">Trang chủ</a>
 | <a href="index.php?controller=product&amp;action=index">Sản phẩm</a>
 | <a href="index.php?controller=cart">Giỏ hàng</a></p>
<h1><?php echo htmlspecialchars((string)($product['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h1>
<?php if(empty($variants)){ ?>
<p>Chưa có biến thể cho sản phẩm này.</p>
<?php } else { ?>
<table border="1" cellpadding="8" cellspacing="0">
<thead>
<tr>
<th>Màu</th>
<th>Size</th>
<th>Giá</th>
<th>Ảnh</th>
<th>Thêm vào giỏ</th>
</tr>
</thead>
<tbody>
<?php foreach($variants as $v){
$vid=(int)($v['id'] ?? 0);
?>
<tr>
<td><?php echo htmlspecialchars((string)($v['color'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars((string)($v['size'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo number_format((int)($v['price'] ?? 0), 0, ',', '.'); ?></td>
<td><?php $im=$v['image'] ?? ''; if($im!==''){ ?><img src="<?php echo htmlspecialchars((string)$im, ENT_QUOTES, 'UTF-8'); ?>" alt="" width="64"><?php } ?></td>
<td>
<form method="post" action="index.php?controller=cart&amp;action=store">
<input type="hidden" name="variant_id" value="<?php echo $vid; ?>">
<input type="number" name="quantity" min="1" value="1">
<button type="submit">Thêm vào giỏ</button>
</form>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>
</body>
</html>
