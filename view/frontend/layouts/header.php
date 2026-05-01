<?php

require_once __DIR__ . '/_helpers.php';

$pageTitle = isset($pageTitle) ? $pageTitle : 'Fashion Store';
$layoutExtraCss = isset($layoutExtraCss) ? $layoutExtraCss : array();
$bodyClass = isset($bodyClass) ? $bodyClass : '';
$navActive = isset($navActive) ? $navActive : '';

$menus_for_sidebar = array();
if (!empty($menus) && is_array($menus)) {
    $menus_for_sidebar = $menus;
} elseif (!empty($categories) && is_array($categories)) {
    $menus_for_sidebar = $categories;
}

$logged_in_nav = isset($logged_in) ? !empty($logged_in) : !empty($_SESSION['user_id']);
$user_email_nav = isset($user_email) ? (string) $user_email : (isset($_SESSION['user_email']) ? (string) $_SESSION['user_email'] : '');

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars((string) $pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars(app_asset('css/base.css')); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(app_asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(app_asset('css/user.css')); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(app_asset('css/header-nav.css')); ?>">
<?php foreach ($layoutExtraCss as $css) { ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars(app_asset('css/' . ltrim((string) $css, '/'))); ?>">
<?php } ?>
</head>
<body<?php echo $bodyClass !== '' ? ' class="' . htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside class="shop-sidebar hidden-sidebar" id="sidebar">
    <div class="sidebar-top">
        <h3>Bộ lọc</h3>
        <span class="close-sidebar" onclick="closeSidebar()">✕</span>
    </div>
    <div class="filter-box">
        <h3>Danh mục</h3>
        <ul>
            <li><a href="<?php echo htmlspecialchars(app_route('category')); ?>">Tất cả danh mục</a></li>
<?php foreach ($menus_for_sidebar as $m) {
        $mid = layout_row_int($m, array('id', 'category_id'));
        $mname = layout_row_str($m, array('name', 'category_name'), 'Danh mục');
?>
            <li><a href="<?php echo htmlspecialchars(app_route('category', 'show', array('id' => $mid))); ?>"><?php echo htmlspecialchars($mname, ENT_QUOTES, 'UTF-8'); ?></a></li>
<?php } ?>
        </ul>
    </div>
</aside>

<header class="header">
    <div class="container header-inner">
        <div class="header-left">
            <span class="menu-toggle" onclick="openSidebar()" role="button" tabindex="0">☰</span>
            <div class="logo">
                <a href="<?php echo htmlspecialchars(app_route('home')); ?>">
                    <img src="<?php echo htmlspecialchars(app_asset('images/logo.png')); ?>" alt="Logo">
                </a>
            </div>
        </div>
        <nav class="nav">
            <a href="<?php echo htmlspecialchars(app_route('home')); ?>" class="<?php echo $navActive === 'home' ? 'active' : ''; ?>">Trang chủ</a>
            <a href="<?php echo htmlspecialchars(app_route('product')); ?>" class="<?php echo $navActive === 'shop' ? 'active' : ''; ?>">Sản phẩm</a>
            <a href="<?php echo htmlspecialchars(app_route('category')); ?>" class="<?php echo $navActive === 'categories' ? 'active' : ''; ?>">Danh mục</a>
            <a href="<?php echo htmlspecialchars(app_route('invoice')); ?>" class="<?php echo $navActive === 'orders' ? 'active' : ''; ?>">Đơn hàng</a>
        </nav>
        <div class="header-actions">
            <form class="hdr-search-inline" id="hdrSearchInline" method="get" action="<?php echo htmlspecialchars(app_route('product')); ?>" role="search" hidden>
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="index">
                <div class="input-container">
                    <input type="text" name="q" id="hdrSearchInput" class="input" placeholder="Tìm kiếm..." autocomplete="off">
                    <span class="icon" aria-hidden="true">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="1" d="M14 5H20" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path opacity="1" d="M14 8H17" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M21 11.5C21 16.75 16.75 21 11.5 21C6.25 21 2 16.75 2 11.5C2 6.25 6.25 2 11.5 2" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path opacity="1" d="M22 22L20 20" stroke="#000" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <button type="button" class="hdr-search-close-inline" id="hdrSearchClose" aria-label="Đóng">×</button>
            </form>
            <div class="button-container" id="hdrButtonContainer" role="group" aria-label="Điều hướng">
                <a class="button <?php echo $navActive === 'home' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars(app_route('home')); ?>" aria-label="Trang chủ">
                    <svg class="icon" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M946.5 505L560.1 118.8l-25.9-25.9a31.5 31.5 0 0 0-44.4 0L77.5 505a63.9 63.9 0 0 0-18.8 46c.4 35.2 29.7 63.3 64.9 63.3h42.5V940h691.8V614.3h43.4c17.1 0 33.2-6.7 45.3-18.8a63.6 63.6 0 0 0 18.7-45.3c0-17-6.7-33.1-18.8-45.2zM568 868H456V664h112v204zm217.9-325.7V868H632V640c0-22.1-17.9-40-40-40H432c-22.1 0-40 17.9-40 40v228H238.1V542.3h-96l370-369.7 23.1 23.1L882 542.3h-96.1z"></path>
                    </svg>
                </a>
                <button type="button" class="button" id="hdrSearchBtn" aria-label="Tìm sản phẩm" aria-controls="hdrSearchInline" aria-expanded="false">
                    <svg class="icon" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
<?php if ($logged_in_nav) { ?>
                <a class="button" href="<?php echo htmlspecialchars(app_route('auth', 'profile')); ?>" aria-label="Tài khoản" title="<?php echo htmlspecialchars($user_email_nav, ENT_QUOTES, 'UTF-8'); ?>">
                    <svg class="icon" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2.5a5.5 5.5 0 0 1 3.096 10.047 9.005 9.005 0 0 1 5.9 8.181.75.75 0 1 1-1.499.044 7.5 7.5 0 0 0-14.993 0 .75.75 0 0 1-1.5-.045 9.005 9.005 0 0 1 5.9-8.18A5.5 5.5 0 0 1 12 2.5ZM8 8a4 4 0 1 0 8 0 4 4 0 0 0-8 0Z"></path>
                    </svg>
                </a>
<?php } else { ?>
                <a class="button" href="<?php echo htmlspecialchars(app_route('auth', 'login')); ?>" aria-label="Đăng nhập">
                    <svg class="icon" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2.5a5.5 5.5 0 0 1 3.096 10.047 9.005 9.005 0 0 1 5.9 8.181.75.75 0 1 1-1.499.044 7.5 7.5 0 0 0-14.993 0 .75.75 0 0 1-1.5-.045 9.005 9.005 0 0 1 5.9-8.18A5.5 5.5 0 0 1 12 2.5ZM8 8a4 4 0 1 0 8 0 4 4 0 0 0-8 0Z"></path>
                    </svg>
                </a>
<?php } ?>
                <a class="button <?php echo $navActive === 'cart' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars(app_route('cart')); ?>" aria-label="Giỏ hàng">
                    <svg class="icon" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>

<main class="main">
