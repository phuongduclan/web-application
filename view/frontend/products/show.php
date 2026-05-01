<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$pname = layout_row_str(isset($product) && is_array($product) ? $product : array(), array('name', 'product_name'), 'Sản phẩm');
$variants = isset($variants) && is_array($variants) ? $variants : array();

$jsonVariants = array();
foreach ($variants as $v) {
    $jsonVariants[] = array(
        'id' => layout_row_int($v, array('id', 'variant_id', 'varient_id')),
        'size' => (string) ($v['size'] ?? ''),
        'color' => (string) ($v['color'] ?? ''),
        'price' => (int) ($v['price'] ?? 0),
        'image' => (string) ($v['image'] ?? ''),
    );
}

$firstPrice = isset($jsonVariants[0]) ? $jsonVariants[0]['price'] : 0;
$firstImage = '';
foreach ($jsonVariants as $jv) {
    if ($jv['image'] !== '') {
        $firstImage = $jv['image'];
        break;
    }
}
if ($firstImage === '') {
    $firstImage = app_asset('images/products/product-1.jpg');
}

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => $pname,
    'navActive' => 'shop',
    'layoutExtraCss' => array('product-detail.css'),
));

?>
<section class="pd-page">
    <div class="container">
        <p class="pd-breadcrumb">
            <a href="<?php echo htmlspecialchars(app_route('home')); ?>">Trang chủ</a>
            · <a href="<?php echo htmlspecialchars(app_route('product')); ?>">Sản phẩm</a>
            · <span><?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?></span>
        </p>

<?php if (empty($variants)) { ?>
        <div class="pd-grid">
            <div class="pd-info" style="grid-column: 1 / -1;">
                <h1><?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="pd-flash">Chưa có biến thể cho sản phẩm này.</p>
                <a href="<?php echo htmlspecialchars(app_route('product')); ?>" class="pd-cta" style="display:inline-block;text-align:center;text-decoration:none;width:auto;padding:12px 22px;">Quay lại cửa hàng</a>
            </div>
        </div>
<?php } else { ?>
        <div id="pdRoot" class="pd-grid">
            <div class="pd-gallery">
                <div class="pd-gallery-main">
                    <img data-pd-main src="<?php echo htmlspecialchars($firstImage, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="pd-thumbs" data-pd-thumbs></div>
            </div>

            <div class="pd-info">
                <h1><?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?></h1>

                <div class="pd-price-row">
                    <span class="pd-price" data-pd-price><?php echo number_format($firstPrice, 0, ',', '.'); ?> đ</span>
                    <span class="pd-tag">Miễn phí ship cho đơn ≥ 500k</span>
                </div>

                <div class="pd-block">
                    <p class="pd-label">Size: <strong data-pd-size-label>—</strong></p>
                    <div class="pd-pill-row" data-pd-sizes></div>
                </div>

                <form data-pd-form method="post" action="<?php echo htmlspecialchars(app_route('cart', 'store')); ?>">
                    <input type="hidden" name="variant_id" data-pd-variant-id value="">

                    <div class="pd-block">
                        <p class="pd-label">Số lượng</p>
                        <div class="pd-qty-row">
                            <div class="pd-qty">
                                <button type="button" data-pd-qty-minus aria-label="Giảm">−</button>
                                <input type="number" name="quantity" min="1" value="1" data-pd-qty>
                                <button type="button" data-pd-qty-plus aria-label="Tăng">+</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="pd-cta" data-pd-cta>Thêm vào giỏ hàng</button>
                </form>

                <div class="pd-block" style="margin-top:24px;">
                    <p class="pd-label">Chọn màu khác: <strong data-pd-color-label>—</strong></p>
                    <div class="pd-swatch-row" data-pd-colors></div>
                </div>

                <div class="pd-accordion">
                    <details open>
                        <summary>Thông tin sản phẩm</summary>
                        <div class="pd-acc-body">
                            <p>Mã sản phẩm: <strong>#<?php echo (int) ($product['id'] ?? 0); ?></strong></p>
                            <p>Sản phẩm có nhiều biến thể size và màu, vui lòng chọn trước khi thêm vào giỏ.</p>
                        </div>
                    </details>
                    <details>
                        <summary>Hướng dẫn chọn size</summary>
                        <div class="pd-acc-body">
                            <p>Tham khảo bảng size theo chiều cao và cân nặng. Liên hệ hỗ trợ nếu phân vân giữa hai size.</p>
                        </div>
                    </details>
                    <details>
                        <summary>Đổi trả &amp; vận chuyển</summary>
                        <div class="pd-acc-body">
                            <p>Đổi trả miễn phí trong 7 ngày. Giao toàn quốc 1–3 ngày làm việc.</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <script type="application/json" id="pdVariants"><?php echo json_encode($jsonVariants, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
<?php } ?>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer', array(
    'layoutExtraJs' => array('product-detail.js'),
));
?>
