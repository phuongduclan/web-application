<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn <?php echo (int)($invoice['id'] ?? 0); ?></title>
</head>
<body>
<h1>Đơn hàng #<?php echo (int)($invoice['id'] ?? 0); ?></h1>
<p><a href="index.php?controller=invoice&amp;action=index">Danh sách đơn</a> | <a href="index.php?controller=home">Trang chủ</a></p>
<?php if(!empty($invoiceMessage)){ ?>
<p><?php echo htmlspecialchars((string)$invoiceMessage, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>
<p><strong>Trạng thái:</strong> <?php echo htmlspecialchars((string)($status['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
<?php if(!empty($canCancel)){ ?>
<form method="post" action="index.php?controller=invoice&amp;action=cancel">
<input type="hidden" name="invoice_id" value="<?php echo (int)($invoice['id'] ?? 0); ?>">
<button type="submit">Hủy đơn</button>
</form>
<?php } ?>
<p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars((string)($invoice['address'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Điện thoại:</strong> <?php echo htmlspecialchars((string)($invoice['phone'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Ghi chú:</strong> <?php echo htmlspecialchars((string)($invoice['note'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Tổng:</strong> <?php echo number_format((int)($invoice['total_amount'] ?? 0), 0, ',', '.'); ?></p>
<?php if(!empty($payment)){ ?>
<p><strong>Thanh toán:</strong> <?php echo htmlspecialchars((string)$paymentMethodName, ENT_QUOTES, 'UTF-8'); ?>
 — <?php echo number_format((int)($payment['payment_amount'] ?? 0), 0, ',', '.'); ?>
 (<?php echo htmlspecialchars((string)($payment['payment_date'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>)</p>
<?php } ?>
<h2>Sản phẩm</h2>
<table border="1" cellpadding="6" cellspacing="0">
<thead><tr><th>Tên</th><th>Màu</th><th>Size</th><th>Đơn giá</th><th>SL</th><th>Thành tiền</th></tr></thead>
<tbody>
<?php foreach($details as $d){
$pr=(int)($d['price'] ?? 0);
$qt=(int)($d['quantity'] ?? 0);
?>
<tr>
<td><?php echo htmlspecialchars((string)($d['product_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars((string)($d['color'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars((string)($d['size'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo number_format($pr, 0, ',', '.'); ?></td>
<td><?php echo $qt; ?></td>
<td><?php echo number_format($pr*$qt, 0, ',', '.'); ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</body>
</html>
