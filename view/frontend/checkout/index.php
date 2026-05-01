<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => 'Thanh toán',
    'navActive' => 'cart',
    'layoutExtraCss' => array('checkout.css'),
));

$methods = isset($methods) ? $methods : array();
$cart = isset($cart) ? $cart : array();
$cartTotal = isset($cartTotal) ? $cartTotal : 0;
$checkoutError = isset($checkoutError) ? $checkoutError : null;

$shipping = 0;
$grandTotal = (int) $cartTotal + $shipping;

?>
<section class="co-page">
    <div class="container">
        <div class="co-head">
            <h2>Thanh toán</h2>
            <p class="co-crumb">
                <a href="<?php echo htmlspecialchars(app_route('cart')); ?>">← Giỏ hàng</a>
                · <a href="<?php echo htmlspecialchars(app_route('product')); ?>">Tiếp tục mua</a>
            </p>
        </div>

<?php if (!empty($checkoutError)) { ?>
        <p class="co-error"><?php echo htmlspecialchars((string) $checkoutError, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>

        <div class="co-grid">
            <form class="co-card" method="post" action="<?php echo htmlspecialchars(app_route('checkout', 'store')); ?>">
                <h3>Thông tin giao hàng</h3>
                <div class="co-form">
                    <div class="co-field co-field-full">
                        <label for="co_address">Địa chỉ nhận hàng</label>
                        <input type="text" id="co_address" name="address" required maxlength="255" placeholder="Số nhà, đường, phường, quận, thành phố">
                    </div>
                    <div class="co-field">
                        <label for="co_phone">Số điện thoại</label>
                        <input type="tel" id="co_phone" name="phone" required maxlength="15" placeholder="VD: 0901234567">
                    </div>
                    <div class="co-field">
                        <label for="co_note">Ghi chú (tuỳ chọn)</label>
                        <input type="text" id="co_note" name="note" maxlength="255" placeholder="VD: giao giờ hành chính">
                    </div>
                </div>

                <h3 style="margin-top:22px;">Phương thức thanh toán</h3>
<?php if (empty($methods)) { ?>
                <p class="co-error">Hệ thống chưa cấu hình phương thức thanh toán.</p>
<?php } else { ?>
                <div class="co-method">
<?php $first = true; foreach ($methods as $m) {
        $mid = layout_row_int($m, array('id', 'method_id'));
        $mname = layout_row_str($m, array('name', 'method_name'), 'Phương thức');
?>
                    <label class="<?php echo $first ? 'is-active' : ''; ?>">
                        <input type="radio" name="method_id" value="<?php echo $mid; ?>" required<?php echo $first ? ' checked' : ''; ?>>
                        <span><?php echo htmlspecialchars($mname, ENT_QUOTES, 'UTF-8'); ?></span>
                    </label>
<?php $first = false; } ?>
                </div>
<?php } ?>

                <button type="submit" class="co-cta">Xác nhận đặt hàng</button>
            </form>

            <aside class="co-card co-summary">
                <h3>Đơn hàng (<?php echo count($cart); ?> sản phẩm)</h3>

                <div>
<?php foreach ($cart as $line) {
        $u = (int) ($line['price'] ?? 0);
        $q = (int) ($line['qty'] ?? 0);
        $img = (string) ($line['image'] ?? '');
        $name = (string) ($line['product_name'] ?? '');
        $color = (string) ($line['color'] ?? '');
        $size = (string) ($line['size'] ?? '');
?>
                    <div class="co-line">
                        <div class="co-line-img">
<?php if ($img !== '') { ?>
                            <img src="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="">
<?php } else { ?>
                            <img src="<?php echo htmlspecialchars(app_asset('images/products/product-1.jpg')); ?>" alt="">
<?php } ?>
                            <span class="co-line-qty"><?php echo $q; ?></span>
                        </div>
                        <div class="co-line-info">
                            <p class="co-line-name"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="co-line-meta">
<?php if ($color !== '') { ?><?php echo htmlspecialchars($color, ENT_QUOTES, 'UTF-8'); ?><?php } ?>
<?php if ($color !== '' && $size !== '') { ?> · <?php } ?>
<?php if ($size !== '') { ?>Size <?php echo htmlspecialchars($size, ENT_QUOTES, 'UTF-8'); ?><?php } ?>
                            </p>
                        </div>
                        <div class="co-line-total"><?php echo number_format($u * $q, 0, ',', '.'); ?> đ</div>
                    </div>
<?php } ?>
                </div>

                <div class="co-totals">
                    <div class="co-totals-row">
                        <span>Tạm tính</span>
                        <strong><?php echo number_format((int) $cartTotal, 0, ',', '.'); ?> đ</strong>
                    </div>
                    <div class="co-totals-row">
                        <span>Phí vận chuyển</span>
                        <strong><?php echo $shipping > 0 ? number_format($shipping, 0, ',', '.') . ' đ' : 'Miễn phí'; ?></strong>
                    </div>
                    <div class="co-totals-row is-grand">
                        <span>Tổng thanh toán</span>
                        <strong><?php echo number_format($grandTotal, 0, ',', '.'); ?> đ</strong>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<script>
(function () {
  var labels = document.querySelectorAll('.co-method label');
  labels.forEach(function (lb) {
    var input = lb.querySelector('input[type="radio"]');
    if (!input) { return; }
    input.addEventListener('change', function () {
      labels.forEach(function (other) { other.classList.remove('is-active'); });
      lb.classList.add('is-active');
    });
  });
})();
</script>
<?php
$this->view('frontend.layouts.footer');
?>
