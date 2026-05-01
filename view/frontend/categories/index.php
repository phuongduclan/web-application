<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'menus' => isset($categories) ? $categories : array(),
    'pageTitle' => 'Danh mục',
    'navActive' => 'categories',
));
?>
<section class="product-page">
    <div class="container">
        <div class="section-header">
            <h2>Danh mục</h2>
            <p>Chọn danh mục để xem <strong>sản phẩm theo danh mục</strong>.</p>
        </div>
<?php if (empty($categories)) { ?>
        <p>Không có danh mục.</p>
<?php } else { ?>
        <ul style="list-style:none;padding:0;display:grid;gap:0.75rem;">
<?php foreach ($categories as $c) {
        $cid = (int) ($c['id'] ?? $c['category_id'] ?? 0);
        $cname = (string) ($c['name'] ?? $c['category_name'] ?? 'Danh mục');
?>
            <li><a class="btn btn-outline" href="<?php echo htmlspecialchars(app_route('category', 'show', array('id' => $cid))); ?>"><?php echo htmlspecialchars($cname, ENT_QUOTES, 'UTF-8'); ?></a></li>
<?php } ?>
        </ul>
<?php } ?>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
