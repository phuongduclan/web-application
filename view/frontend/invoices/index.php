<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của tôi</title>
</head>
<body>
<h1>Đơn hàng của tôi</h1>
<p><a href="index.php?controller=home">Trang chủ</a> | <a href="index.php?controller=cart">Giỏ hàng</a></p>
<?php if(empty($invoices)){ ?>
<p>Chưa có đơn hàng.</p>
<?php } else { ?>
<table border="1" cellpadding="8" cellspacing="0">
<thead><tr><th>Mã</th><th>Ngày</th><th>Tổng</th><th>Trạng thái</th><th></th></tr></thead>
<tbody>
<?php foreach($invoices as $inv){ ?>
<tr>
<td><?php echo (int)($inv['id'] ?? 0); ?></td>
<td><?php echo htmlspecialchars((string)($inv['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo number_format((int)($inv['total_amount'] ?? 0), 0, ',', '.'); ?></td>
<td><?php echo htmlspecialchars((string)($inv['status_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
<td><a href="index.php?controller=invoice&amp;action=show&amp;invoice_id=<?php echo (int)($inv['id'] ?? 0); ?>">Chi tiết</a></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>
</body>
</html>
