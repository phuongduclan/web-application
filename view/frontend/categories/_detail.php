<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$category = isset($category) && is_array($category) ? $category : array();
$products = isset($products) && is_array($products) ? $products : array();
$cname = layout_row_str($category, array('name', 'category_name'), 'Danh mục');

?>
<section class="product-page">
    <div class="container">
        <div class="section-header">
            <p class="page-eyebrow">Sản phẩm theo danh mục</p>
            <h2><?php echo htmlspecialchars($cname, ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><a href="<?php echo htmlspecialchars(app_route('category')); ?>">← Tất cả danh mục</a> · <a href="<?php echo htmlspecialchars(app_route('product')); ?>">Danh sách sản phẩm</a></p>
        </div>
<?php if (empty($products)) { ?>
        <p>Chưa có sản phẩm trong danh mục này.</p>
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
