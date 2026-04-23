<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán</title>
</head>
<body>
<h1>Thanh toán</h1>
<p><a href="index.php?controller=cart">Giỏ hàng</a> | <a href="index.php?controller=home">Trang chủ</a></p>
<?php if(!empty($checkoutError)){ ?>
<p><?php echo htmlspecialchars((string)$checkoutError, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<h2>Đơn hàng</h2>
<table border="1" cellpadding="6" cellspacing="0">
<thead><tr><th>Tên</th><th>Màu</th><th>Size</th><th>Đơn giá</th><th>SL</th><th>Thành tiền</th></tr></thead>
<tbody>
<?php foreach($cart as $k=>$line){
$u=(int)($line['price'] ?? 0);
$q=(int)($line['qty'] ?? 0);
?>
<tr>
<td><?php echo htmlspecialchars((string)($line['product_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars((string)($line['color'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars((string)($line['size'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo number_format($u, 0, ',', '.'); ?></td>
<td><?php echo $q; ?></td>
<td><?php echo number_format($u*$q, 0, ',', '.'); ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<p><strong>Tổng thanh toán:</strong> <?php echo number_format((int)$cartTotal, 0, ',', '.'); ?></p>
<h2>Thông tin giao hàng</h2>
<form method="post" action="index.php?controller=checkout&amp;action=store">
<p><label>Địa chỉ<br><input type="text" name="address" required maxlength="255"></label></p>
<p><label>Số điện thoại<br><input type="text" name="phone" required maxlength="15"></label></p>
<p><label>Ghi chú<br><input type="text" name="note" maxlength="255"></label></p>
<p><label>Phương thức thanh toán<br>
<select name="method_id" required>
<option value="">-- Chọn --</option>
<?php foreach($methods as $m){ ?>
<option value="<?php echo (int)($m['id'] ?? 0); ?>"><?php echo htmlspecialchars((string)($m['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></option>
<?php } ?>
</select></label></p>
<p><button type="submit">Xác nhận đặt hàng</button></p>
</form>
</body>
</html>
