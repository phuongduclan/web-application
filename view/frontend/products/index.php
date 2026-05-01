<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => 'Danh sách sản phẩm',
    'navActive' => 'shop',
));

?>
<section class="product-page">
    <div class="container">
        <div class="section-header">
            <h2>Danh sách sản phẩm</h2>
            <p>Chọn sản phẩm để xem biến thể và thêm vào giỏ — hoặc xem theo <a href="<?php echo htmlspecialchars(app_route('category')); ?>">danh mục</a>.</p>
        </div>
<?php if (empty($products)) { ?>
        <p>Không có sản phẩm.</p>
<?php } else { ?>
        <div class="product-grid">
<?php foreach ($products as $p) {
        $pid = layout_row_int($p, array('id', 'product_id'));
        $pname = layout_row_str($p, array('name', 'product_name'), 'Sản phẩm');
?>
            <div class="product-card">
                <a href="<?php echo htmlspecialchars(app_route('product', 'show', array('product_id' => $pid))); ?>">
                    <img src="<?php echo htmlspecialchars(layout_product_card_image($p)); ?>" alt="<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?>">
                </a>
                <h3><?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?></h3>
                <a href="<?php echo htmlspecialchars(app_route('product', 'show', array('product_id' => $pid))); ?>" class="btn">Chi tiết</a>
            </div>
<?php } ?>
        </div>
<?php } ?>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
