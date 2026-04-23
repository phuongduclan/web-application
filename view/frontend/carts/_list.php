<?php
$cart=$cart ?? [];
$cartTotal=$cartTotal ?? 0;
$cartError=$cartError ?? null;
$logged_in=$logged_in ?? false;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
</head>
<body>
<h1>Giỏ hàng</h1>
<?php if($cartError!==null && $cartError!==''){ ?>
<p><?php echo htmlspecialchars((string)$cartError, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<?php if(empty($cart)){ ?>
<p>Giỏ hàng đang trống.</p>
<p><a href="index.php?controller=category&amp;action=index">Danh mục</a></p>
<?php } else { ?>
<table border="1" cellpadding="8" cellspacing="0">
<thead>
<tr>
<th>Ảnh</th>
<th>Tên</th>
<th>Màu</th>
<th>Size</th>
<th>Đơn giá</th>
<th>Số lượng</th>
<th>Thành tiền</th>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach($cart as $variantKey=>$line){
$unit=(int)($line['price'] ?? 0);
$qty=(int)($line['qty'] ?? 0);
$lineTotal=$unit*$qty;
$img=$line['image'] ?? '';
$name=$line['product_name'] ?? '';
?>
<tr>
<td><?php if($img!==''){ ?><img src="<?php echo htmlspecialchars((string)$img, ENT_QUOTES, 'UTF-8'); ?>" alt="" width="48"><?php } ?></td>
<td><?php echo htmlspecialchars((string)$name, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars((string)($line['color'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars((string)($line['size'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo number_format($unit, 0, ',', '.'); ?></td>
<td>
<form method="post" action="index.php?controller=cart&amp;action=update&amp;variant_id=<?php echo urlencode((string)$variantKey); ?>">
<input type="number" name="quantity" min="1" value="<?php echo $qty; ?>">
<button type="submit">Cập nhật</button>
</form>
</td>
<td><?php echo number_format($lineTotal, 0, ',', '.'); ?></td>
<td><a href="index.php?controller=cart&amp;action=destroy&amp;variant_id=<?php echo urlencode((string)$variantKey); ?>">Xóa</a></td>
</tr>
<?php } ?>
</tbody>
</table>
<p><strong>Tổng cộng:</strong> <?php echo number_format($cartTotal, 0, ',', '.'); ?></p>
<?php if(!empty($logged_in)){ ?>
<p><a href="index.php?controller=checkout">Thanh toán</a></p>
<?php } else { ?>
<p><a href="index.php?controller=auth&amp;action=login">Đăng nhập để thanh toán</a></p>
<?php } ?>
<?php } ?>
</body>
</html>
