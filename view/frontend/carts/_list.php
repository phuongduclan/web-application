<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$cart = isset($cart) ? $cart : array();
$cartTotal = isset($cartTotal) ? $cartTotal : 0;
$cartError = isset($cartError) ? $cartError : null;
$logged_in = isset($logged_in) ? $logged_in : false;

?>
<section class="cart-page">
    <div class="container">
        <div class="section-header cart-header">
            <p class="page-eyebrow">Giỏ hàng</p>
            <h2>Sản phẩm của bạn</h2>
        </div>

<?php if ($cartError !== null && $cartError !== '') { ?>
        <p style="color:#c00;"><?php echo htmlspecialchars((string) $cartError, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>

<?php if (empty($cart)) { ?>
        <p>Giỏ hàng đang trống.</p>
        <p><a href="<?php echo htmlspecialchars(app_route('product')); ?>" class="btn">Tiếp tục mua</a></p>
<?php } else { ?>
        <div class="cart-layout">
            <div class="cart-items">
<?php foreach ($cart as $variantKey => $line) {
        $unit = (int) ($line['price'] ?? 0);
        $qty = (int) ($line['qty'] ?? 0);
        $lineTotal = $unit * $qty;
        $img = isset($line['image']) ? (string) $line['image'] : '';
        $name = isset($line['product_name']) ? (string) $line['product_name'] : '';
?>
                <article class="cart-item">
<?php if ($img !== '') { ?>
                    <img src="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="">
<?php } else { ?>
                    <img src="<?php echo htmlspecialchars(app_asset('images/products/product-1.jpg')); ?>" alt="">
<?php } ?>
                    <div class="cart-item-content">
                        <div class="cart-item-top">
                            <div>
                                <h3><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="cart-item-meta">
                                    Màu: <?php echo htmlspecialchars((string) ($line['color'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                    | Size: <?php echo htmlspecialchars((string) ($line['size'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                            </div>
                            <a class="text-btn" href="<?php echo htmlspecialchars(app_route('cart', 'destroy', array('variant_id' => $variantKey))); ?>">Xóa</a>
                        </div>
                        <div class="cart-item-bottom">
                            <form method="post" action="<?php echo htmlspecialchars(app_route('cart', 'update', array('variant_id' => $variantKey))); ?>" style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap;">
                                <label>Số lượng <input type="number" name="quantity" min="1" value="<?php echo $qty; ?>" style="width:4rem;"></label>
                                <button type="submit" class="btn btn-outline">Cập nhật</button>
                            </form>
                            <p class="cart-item-price"><?php echo number_format($lineTotal, 0, ',', '.'); ?> đ</p>
                        </div>
                    </div>
                </article>
<?php } ?>
                <div class="cart-note">
                    <p>Cần thêm gì nữa?</p>
                    <a href="<?php echo htmlspecialchars(app_route('product')); ?>">Tiếp tục mua</a>
                </div>
            </div>

            <aside class="order-card">
                <h3>Tóm tắt</h3>
                <div class="summary-total">
                    <span>Tổng</span>
                    <strong><?php echo number_format((int) $cartTotal, 0, ',', '.'); ?> đ</strong>
                </div>
<?php if (!empty($logged_in)) { ?>
                <a href="<?php echo htmlspecialchars(app_route('checkout')); ?>" class="btn cart-cta">Thanh toán</a>
<?php } else { ?>
                <p><a href="<?php echo htmlspecialchars(app_route('auth', 'login')); ?>" class="btn cart-cta">Đăng nhập để thanh toán</a></p>
<?php } ?>
            </aside>
        </div>
<?php } ?>
    </div>
</section>
