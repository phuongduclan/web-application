<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$searchQuery = isset($searchQuery) ? (string) $searchQuery : '';
$products = isset($products) ? $products : array();

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => $searchQuery !== '' ? ('Tìm: ' . $searchQuery) : 'Danh sách sản phẩm',
    'navActive' => 'shop',
));

?>
<section class="product-page">
    <div class="container">
        <div class="section-header">
<?php if ($searchQuery !== '') { ?>
            <p class="page-eyebrow" style="font-size:.75rem;letter-spacing:.12em;text-transform:uppercase;color:#6b6b6b;margin:0 0 6px;">Kết quả tìm kiếm</p>
            <h2>Có <?php echo count($products); ?> sản phẩm khớp với "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>"</h2>
            <p>
                <a href="<?php echo htmlspecialchars(app_route('product')); ?>" style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:#111;color:#fff;border-radius:999px;font-size:.85rem;font-weight:600;">← Xóa bộ lọc</a>
                hoặc xem theo <a href="<?php echo htmlspecialchars(app_route('category')); ?>">danh mục</a>.
            </p>
<?php } else { ?>
            <h2>Danh sách sản phẩm</h2>
            <p>Chọn sản phẩm để xem biến thể và thêm vào giỏ — hoặc xem theo <a href="<?php echo htmlspecialchars(app_route('category')); ?>">danh mục</a>.</p>
<?php } ?>
        </div>
<?php if (empty($products)) { ?>
        <div style="background:#fff;border-radius:14px;padding:56px 24px;text-align:center;box-shadow:0 6px 28px rgba(0,0,0,.04);">
<?php if ($searchQuery !== '') { ?>
            <p style="color:#6b6b6b;margin-bottom:14px;">Không có sản phẩm nào khớp với "<strong><?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?></strong>".</p>
            <a href="<?php echo htmlspecialchars(app_route('product')); ?>" style="display:inline-flex;padding:10px 20px;background:#111;color:#fff;border-radius:999px;font-weight:600;font-size:.9rem;">Xem tất cả sản phẩm</a>
<?php } else { ?>
            <p>Không có sản phẩm.</p>
<?php } ?>
        </div>
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
