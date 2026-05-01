<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => 'Lịch sử đơn hàng',
    'navActive' => 'orders',
    'layoutExtraCss' => array('invoice.css'),
));

$invoices = isset($invoices) ? $invoices : array();

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

?>
<section class="iv-page">
    <div class="container">
        <div class="iv-head">
            <div>
                <p class="iv-eyebrow">Đơn hàng</p>
                <h1>Lịch sử đơn hàng</h1>
            </div>
            <p class="iv-crumb">
                <a href="<?php echo htmlspecialchars(app_route('home')); ?>">Trang chủ</a>
                · <a href="<?php echo htmlspecialchars(app_route('cart')); ?>">Giỏ hàng</a>
                · <span>Đơn hàng</span>
            </p>
        </div>

<?php if (empty($invoices)) { ?>
        <div class="iv-empty">
            <p>Bạn chưa có đơn hàng nào.</p>
            <a class="iv-empty-cta" href="<?php echo htmlspecialchars(app_route('product')); ?>">Khám phá sản phẩm</a>
        </div>
<?php } else { ?>
        <div class="iv-list">
            <div class="iv-list-row iv-list-head">
                <div>Mã đơn</div>
                <div>Ngày đặt</div>
                <div>Tổng</div>
                <div>Trạng thái</div>
                <div></div>
            </div>
<?php foreach ($invoices as $inv) {
        $iid = layout_row_int($inv, array('id', 'invoice_id'));
        $sname = (string) ($inv['status_name'] ?? '—');
        $sLow = function_exists('mb_strtolower') ? mb_strtolower($sname, 'UTF-8') : strtolower($sname);
        $sKey = isset($statusKeyMap[$sLow]) ? $statusKeyMap[$sLow] : 'pending';
?>
            <div class="iv-list-row">
                <div class="iv-list-id">#<?php echo $iid; ?></div>
                <div class="iv-list-date"><?php echo htmlspecialchars((string) ($inv['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="iv-list-total"><?php echo number_format((int) ($inv['total_amount'] ?? 0), 0, ',', '.'); ?> đ</div>
                <div>
                    <span class="iv-pill" data-status="<?php echo htmlspecialchars($sKey, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($sname, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div class="iv-list-action">
                    <a href="<?php echo htmlspecialchars(app_route('invoice', 'show', array('invoice_id' => $iid))); ?>">Chi tiết →</a>
                </div>
            </div>
<?php } ?>
        </div>
<?php } ?>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
