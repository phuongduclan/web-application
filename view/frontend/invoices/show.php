<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$invoice = isset($invoice) && is_array($invoice) ? $invoice : array();
$iid = layout_row_int($invoice, array('id', 'invoice_id'));
$details = isset($details) && is_array($details) ? $details : array();
$status = isset($status) && is_array($status) ? $status : array();
$payment = isset($payment) ? $payment : null;
$paymentMethodName = isset($paymentMethodName) ? $paymentMethodName : '';
$canCancel = isset($canCancel) ? $canCancel : false;
$invoiceMessage = isset($invoiceMessage) ? $invoiceMessage : null;

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => 'Đơn hàng #' . $iid,
    'navActive' => 'orders',
    'layoutExtraCss' => array('invoice.css'),
));

$statusLabel = layout_row_str($status, array('name', 'status_name'), '—');

$statusKeyMap = array(
    'chờ xác nhận' => 'pending',
    'cho xac nhan' => 'pending',
    'đang xử lý'   => 'processing',
    'dang xu ly'   => 'processing',
    'đang giao'    => 'shipping',
    'dang giao'    => 'shipping',
    'hoàn thành'   => 'done',
    'hoan thanh'   => 'done',
    'đã hủy'       => 'cancelled',
    'da huy'       => 'cancelled',
);
$statusLow = function_exists('mb_strtolower') ? mb_strtolower($statusLabel, 'UTF-8') : strtolower($statusLabel);
$statusKey = isset($statusKeyMap[$statusLow]) ? $statusKeyMap[$statusLow] : 'pending';

$total = (int) ($invoice['total_amount'] ?? 0);
$itemsCount = 0;
foreach ($details as $d) {
    $itemsCount += (int) ($d['quantity'] ?? 0);
}

?>
<section class="iv-page">
    <div class="container">
        <div class="iv-head">
            <div>
                <p class="iv-eyebrow">Đơn hàng</p>
                <h1>Đơn #<?php echo $iid; ?></h1>
            </div>
            <p class="iv-crumb">
                <a href="<?php echo htmlspecialchars(app_route('home')); ?>">Trang chủ</a>
                · <a href="<?php echo htmlspecialchars(app_route('invoice')); ?>">Lịch sử đơn hàng</a>
                · <span>Đơn #<?php echo $iid; ?></span>
            </p>
        </div>

<?php if (!empty($invoiceMessage)) { ?>
        <p class="iv-flash"><?php echo htmlspecialchars((string) $invoiceMessage, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>

        <div class="iv-status" data-status="<?php echo htmlspecialchars($statusKey, ENT_QUOTES, 'UTF-8'); ?>">
            <span class="iv-status-dot" aria-hidden="true"></span>
            <div class="iv-status-text">
                <small>Trạng thái đơn hàng</small>
                <strong><?php echo htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8'); ?></strong>
            </div>
<?php if (!empty($canCancel)) { ?>
            <div class="iv-status-actions">
                <form method="post" action="<?php echo htmlspecialchars(app_route('invoice', 'cancel')); ?>" onsubmit="return confirm('Hủy đơn này?');">
                    <input type="hidden" name="invoice_id" value="<?php echo $iid; ?>">
                    <button type="submit" class="iv-cancel-btn">Hủy đơn</button>
                </form>
            </div>
<?php } ?>
            <p class="iv-status-help">Đơn sẽ tự cập nhật khi cửa hàng xử lý. Bạn có thể quay lại <a href="<?php echo htmlspecialchars(app_route('invoice')); ?>">lịch sử đơn hàng</a> bất cứ lúc nào.</p>
        </div>

        <div class="iv-grid">
            <div class="iv-card">
                <h3>Thông tin giao hàng</h3>
                <dl class="iv-meta">
                    <div>
                        <dt>Địa chỉ</dt>
                        <dd><?php echo htmlspecialchars((string) ($invoice['address'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></dd>
                    </div>
                    <div>
                        <dt>Điện thoại</dt>
                        <dd><?php echo htmlspecialchars((string) ($invoice['phone'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></dd>
                    </div>
                    <div>
                        <dt>Ghi chú</dt>
                        <dd><?php echo htmlspecialchars((string) ($invoice['note'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></dd>
                    </div>
                    <div>
                        <dt>Ngày đặt</dt>
                        <dd><?php echo htmlspecialchars((string) ($invoice['created_at'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></dd>
                    </div>
                </dl>
            </div>

            <div class="iv-card">
                <h3>Thanh toán</h3>
                <dl class="iv-meta">
                    <div>
                        <dt>Phương thức</dt>
                        <dd><?php echo $paymentMethodName !== '' ? htmlspecialchars($paymentMethodName, ENT_QUOTES, 'UTF-8') : '—'; ?></dd>
                    </div>
<?php if (!empty($payment) && is_array($payment)) { ?>
                    <div>
                        <dt>Đã thanh toán</dt>
                        <dd><?php echo number_format((int) ($payment['payment_amount'] ?? 0), 0, ',', '.'); ?> đ</dd>
                    </div>
                    <div>
                        <dt>Ngày thanh toán</dt>
                        <dd><?php echo htmlspecialchars((string) ($payment['payment_date'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></dd>
                    </div>
<?php } ?>
                    <div>
                        <dt>Tổng đơn</dt>
                        <dd><strong><?php echo number_format($total, 0, ',', '.'); ?> đ</strong></dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="iv-items">
            <h3>Sản phẩm &amp; biến thể (<?php echo $itemsCount; ?>)</h3>
            <p class="iv-items-sub">Mỗi dòng là một biến thể đã chọn khi đặt — gồm mã biến thể, màu, size và ảnh.</p>

<?php foreach ($details as $d) {
        $pr = (int) ($d['price'] ?? 0);
        $qt = (int) ($d['quantity'] ?? 0);
        $vid = layout_row_int($d, array('variant_id', 'variant_pv_id'));
        $col = layout_row_str($d, array('variant_color', 'color'), '');
        $sz = layout_row_str($d, array('variant_size', 'size'), '');
        $img = layout_row_str($d, array('variant_image', 'image'), '');
        $pname = layout_row_str($d, array('product_name'), 'Sản phẩm');
        $pid = layout_row_int($d, array('product_id'));
?>
            <div class="iv-line">
                <div class="iv-line-img">
<?php if ($img !== '') { ?>
                    <img src="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="">
<?php } else { ?>
                    <img src="<?php echo htmlspecialchars(app_asset('images/products/product-1.jpg')); ?>" alt="">
<?php } ?>
                </div>
                <div>
                    <p class="iv-line-name">
                        <?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?>
<?php if ($pid > 0) { ?>
                        <a href="<?php echo htmlspecialchars(app_route('product', 'show', array('product_id' => $pid))); ?>">Xem sản phẩm</a>
<?php } ?>
                    </p>
                    <p class="iv-line-meta">
                        <span class="iv-vid">#<?php echo $vid; ?></span>
<?php if ($sz !== '') { ?>Size <?php echo htmlspecialchars($sz, ENT_QUOTES, 'UTF-8'); ?><?php } ?>
<?php if ($sz !== '' && $col !== '') { ?> · <?php } ?>
<?php if ($col !== '') { ?>Màu <?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?><?php } ?>
                    </p>
                </div>
                <div class="iv-num"><?php echo number_format($pr, 0, ',', '.'); ?> đ</div>
                <div class="iv-num">×<?php echo $qt; ?></div>
                <div class="iv-num is-bold"><?php echo number_format($pr * $qt, 0, ',', '.'); ?> đ</div>
            </div>
<?php } ?>
        </div>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
