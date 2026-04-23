<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công</title>
</head>
<body>
<h1>Đặt hàng thành công</h1>
<p>Mã đơn hàng: <strong><?php echo (int)($invoice['id'] ?? 0); ?></strong></p>
<p>Tổng tiền: <?php echo number_format((int)($invoice['total_amount'] ?? 0), 0, ',', '.'); ?></p>
<p><a href="index.php?controller=invoice&amp;action=show&amp;invoice_id=<?php echo (int)($invoice['id'] ?? 0); ?>">Xem chi tiết đơn</a>
 | <a href="index.php?controller=invoice&amp;action=index">Danh sách đơn</a>
 | <a href="index.php?controller=home">Trang chủ</a></p>
</body>
</html>
