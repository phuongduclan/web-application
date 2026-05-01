<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'menus' => isset($categories) ? $categories : array(),
    'pageTitle' => 'Trang chủ',
    'navActive' => 'home',
    'logged_in' => isset($logged_in) ? $logged_in : false,
    'user_email' => isset($user_email) ? $user_email : '',
));

/**
 * Ảnh ô "Mua theo danh mục" khớp hàng "Gợi ý" (product-1…4), không xoay banner theo STT.
 */
if (!function_exists('home_category_tile_image_rel')) {
    function home_category_tile_image_rel($cname)
    {
        $n = function_exists('mb_strtolower') ? mb_strtolower((string) $cname, 'UTF-8') : strtolower((string) $cname);
        if (strpos($n, 'hoodie') !== false) {
            return 'images/products/product-2.jpg';
        }
        if (strpos($n, 'phông') !== false || strpos($n, 'basic') !== false) {
            return 'images/products/product-1.jpg';
        }
        if (strpos($n, 'jean') !== false) {
            return 'images/products/product-3.jpg';
        }
        if (strpos($n, 'denim') !== false || strpos($n, 'khoác') !== false) {
            return 'images/products/product-4.jpg';
        }
        return 'images/products/product-1.jpg';
    }
}

?>
<section class="hero">
    <div class="container hero-inner">
        <div class="hero-text">
            <h1>Bộ sưu tập mới</h1>
            <p>Khám phá xu hướng thời trang.</p>
            <p style="margin-top:1rem;display:flex;flex-wrap:wrap;gap:.5rem;">
                <a href="<?php echo htmlspecialchars(app_route('product')); ?>" class="btn">Danh sách sản phẩm</a>
                <a href="<?php echo htmlspecialchars(app_route('category')); ?>" class="btn btn-outline">Danh mục</a>
                <a href="<?php echo htmlspecialchars(app_route('cart')); ?>" class="btn btn-outline">Giỏ hàng</a>
                <a href="<?php echo htmlspecialchars(app_route('invoice')); ?>" class="btn btn-outline">Đơn hàng</a>
            </p>
        </div>
        <div class="hero-image">
            <img src="<?php echo htmlspecialchars(app_asset('images/banners/hero-banner.jpg')); ?>" alt="Banner">
        </div>
    </div>
</section>

<section class="featured-products">
    <div class="container">
        <div class="section-header">
            <h2>Gợi ý</h2>
            <p>Xem đầy đủ trong cửa hàng.</p>
        </div>
        <div class="product-grid">
            <div class="product-card">
                <img src="<?php echo htmlspecialchars(app_asset('images/products/product-1.jpg')); ?>" alt="">
                <h3>Áo phông basic</h3>
                <a href="<?php echo htmlspecialchars(app_route('product')); ?>" class="btn">Cửa hàng</a>
            </div>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars(app_asset('images/products/product-2.jpg')); ?>" alt="">
                <h3>Hoodie</h3>
                <a href="<?php echo htmlspecialchars(app_route('product')); ?>" class="btn">Cửa hàng</a>
            </div>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars(app_asset('images/products/product-3.jpg')); ?>" alt="">
                <h3>Quần jeans</h3>
                <a href="<?php echo htmlspecialchars(app_route('product')); ?>" class="btn">Cửa hàng</a>
            </div>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars(app_asset('images/products/product-4.jpg')); ?>" alt="">
                <h3>Áo khoác denim</h3>
                <a href="<?php echo htmlspecialchars(app_route('product')); ?>" class="btn">Cửa hàng</a>
            </div>
        </div>
    </div>
</section>

<section class="category">
    <div class="container">
        <div class="section-header">
            <h2>Mua theo danh mục</h2>
        </div>
        <div class="category-grid">
<?php
if (!empty($categories)) {
    $cats = $categories;
    $home_cat_order = array(
        'áo phông basic' => 1,
        'hoodie' => 2,
        'quần jeans' => 3,
        'áo khoác denim' => 4,
    );
    usort($cats, function ($a, $b) use ($home_cat_order) {
        $na = function_exists('mb_strtolower')
            ? mb_strtolower((string) ($a['name'] ?? $a['category_name'] ?? ''), 'UTF-8')
            : strtolower((string) ($a['name'] ?? $a['category_name'] ?? ''));
        $nb = function_exists('mb_strtolower')
            ? mb_strtolower((string) ($b['name'] ?? $b['category_name'] ?? ''), 'UTF-8')
            : strtolower((string) ($b['name'] ?? $b['category_name'] ?? ''));
        $oa = isset($home_cat_order[$na]) ? $home_cat_order[$na] : 99;
        $ob = isset($home_cat_order[$nb]) ? $home_cat_order[$nb] : 99;
        if ($oa === $ob) {
            return 0;
        }
        return $oa < $ob ? -1 : 1;
    });
    foreach ($cats as $c) {
        $cid = (int) ($c['id'] ?? $c['category_id'] ?? 0);
        $cname = (string) ($c['name'] ?? $c['category_name'] ?? 'Danh mục');
        $imgRel = home_category_tile_image_rel($cname);
?>
            <a class="category-card" href="<?php echo htmlspecialchars(app_route('category', 'show', array('id' => $cid))); ?>">
                <img src="<?php echo htmlspecialchars(app_asset($imgRel)); ?>" alt="<?php echo htmlspecialchars($cname, ENT_QUOTES, 'UTF-8'); ?>">
                <h3><?php echo htmlspecialchars($cname, ENT_QUOTES, 'UTF-8'); ?></h3>
            </a>
<?php
    }
} else {
?>
            <p><a href="<?php echo htmlspecialchars(app_route('category')); ?>" class="btn">Xem danh mục</a></p>
<?php
}
?>
        </div>
    </div>
</section>

<section class="newsletter">
    <div class="container">
        <div class="newsletter-inner">
            <h2>Nhận bản tin</h2>
            <p>Cập nhật sản phẩm và khuyến mãi.</p>
            <form class="newsletter-form" action="#" method="get" onsubmit="return false;">
                <input type="email" placeholder="Email của bạn">
                <button type="submit" class="btn">Đăng ký</button>
            </form>
        </div>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
