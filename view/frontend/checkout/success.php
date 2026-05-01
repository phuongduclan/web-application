<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$iid = (int) (isset($invoice['id']) ? $invoice['id'] : (isset($invoice['invoice_id']) ? $invoice['invoice_id'] : 0));
$statusRow = isset($status) && is_array($status) ? $status : array();
$statusLabel = layout_row_str($statusRow, array('name', 'status_name'), 'Đã ghi nhận');

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => 'Trạng thái đặt hàng',
    'navActive' => 'orders',
));

?>
<section class="product-page">
    <div class="container">
        <div class="section-header">
            <p class="page-eyebrow">Checkout</p>
            <h2>Đặt hàng thành công</h2>
            <p>Mã đơn: <strong>#<?php echo $iid; ?></strong></p>

            <div style="margin-top:1.25rem;padding:1.25rem;border-radius:12px;background:linear-gradient(135deg,#f0fdf4,#ecfdf5);border:1px solid rgba(34,197,94,.25);">
                <p style="margin:0 0 .35rem;font-size:.85rem;opacity:.85;">Trạng thái đơn đặt hàng</p>
                <p style="margin:0;font-size:1.25rem;font-weight:600;"><?php echo htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8'); ?></p>
                <p style="margin:.75rem 0 0;font-size:.9rem;">Theo dõi chi tiết và mọi thay đổi trạng thái trong <a href="<?php echo htmlspecialchars(app_route('invoice', 'show', array('invoice_id' => $iid))); ?>">trang đơn hàng</a> hoặc <a href="<?php echo htmlspecialchars(app_route('invoice')); ?>">lịch sử đơn hàng</a>.</p>
            </div>

            <p style="margin-top:1rem;">Tổng tiền: <strong><?php echo number_format((int) ($invoice['total_amount'] ?? 0), 0, ',', '.'); ?> đ</strong></p>
            <p style="margin-top:1rem;display:flex;flex-wrap:wrap;gap:.5rem;">
                <a href="<?php echo htmlspecialchars(app_route('invoice', 'show', array('invoice_id' => $iid))); ?>" class="btn">Xem đơn &amp; trạng thái</a>
                <a href="<?php echo htmlspecialchars(app_route('invoice')); ?>" class="btn btn-outline">Lịch sử đơn hàng</a>
                <a href="<?php echo htmlspecialchars(app_route('home')); ?>" class="btn btn-outline">Trang chủ</a>
            </p>
        </div>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
