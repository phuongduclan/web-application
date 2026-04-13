<?php
$raw = $_GET['action'] ?? 'home';
$action = is_string($raw) ? preg_replace('/[^a-z0-9_-]/i', '', $raw) : 'home';
if ($action === '') {
    $action = 'home';
}

$hop_le = ['home', 'product', 'category', 'order', 'user', 'payment'];
if (!in_array($action, $hop_le, true)) {
    $action = 'home';
}

include __DIR__ . '/view/admin/header.php';

switch ($action) {
    case 'product':
        include __DIR__ . '/view/admin/product.php';
        break;
    case 'category':
        include __DIR__ . '/view/admin/category.php';
        break;
    case 'order':
        include __DIR__ . '/view/admin/order.php';
        break;
    case 'user':
        include __DIR__ . '/view/admin/user.php';
        break;
    case 'payment':
        include __DIR__ . '/view/admin/payment.php';
        break;
    case 'home':
    default:
        include __DIR__ . '/view/admin/home.php';
        break;
}

include __DIR__ . '/view/admin/footer.php';
