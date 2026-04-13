<?php
if (!isset($action)) {
    $raw = $_GET['action'] ?? 'home';
    $action = is_string($raw) ? preg_replace('/[^a-z0-9_-]/i', '', $raw) : 'home';
    if ($action === '') {
        $action = 'home';
    }
    $hop_le = ['home', 'product', 'category', 'order', 'user', 'payment'];
    if (!in_array($action, $hop_le, true)) {
        $action = 'home';
    }
}

$thiet_lap_trang = [
    'home'     => ['page_title' => 'Tổng quan — Admin', 'h1' => 'Tổng quan', 'nav' => 'muc-tong-quan'],
    'product'  => ['page_title' => 'Quản lý Sản phẩm — Admin', 'h1' => 'Quản lý Sản phẩm', 'nav' => 'muc-san-pham'],
    'category' => ['page_title' => 'Quản lý Danh mục — Admin', 'h1' => 'Quản lý Danh mục', 'nav' => 'muc-danh-muc'],
    'order'    => ['page_title' => 'Quản lý Đơn hàng — Admin', 'h1' => 'Quản lý Đơn hàng', 'nav' => 'muc-don-hang'],
    'user'     => ['page_title' => 'Quản lý Người dùng — Admin', 'h1' => 'Quản lý Người dùng', 'nav' => 'muc-nguoi-dung'],
    'payment'  => ['page_title' => 'Quản lý Giao dịch — Admin', 'h1' => 'Quản lý Giao dịch', 'nav' => 'muc-giao-dich'],
];

$t = $thiet_lap_trang[$action] ?? $thiet_lap_trang['home'];

$lop_body_phu = [
    'product'  => 'trang-san-pham',
    'category' => 'trang-danh-muc',
    'order'    => 'trang-don-hang',
    'user'     => 'trang-nguoi-dung',
    'payment'  => 'trang-giao-dich',
];
$lop_body = $lop_body_phu[$action] ?? '';

$chu_logo = in_array($action, ['user', 'payment'], true) ? 'ADMIN PANEL' : 'ADMIN';

/* Đường dẫn tương đối theo URL của index.php (cùng thư mục gốc project) */
$css_href = 'assets/css/admin.css';

if (!function_exists('muc_nav')) {
    function muc_nav(string $id, array $t): string {
        return ($t['nav'] === $id) ? 'dang-chon' : '';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($t['page_title'], ENT_QUOTES, 'UTF-8'); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $css_href; ?>">
</head>
<body<?php echo $lop_body !== '' ? ' class="' . htmlspecialchars($lop_body, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
  <div id="khung-admin">
    <aside id="thanh-ben">
      <p id="tieu-de-ben"><?php echo htmlspecialchars($chu_logo, ENT_QUOTES, 'UTF-8'); ?></p>
      <nav id="menu-ben" aria-label="Menu chính">
        <a href="index.php?action=home" id="muc-tong-quan" class="<?php echo htmlspecialchars(muc_nav('muc-tong-quan', $t), ENT_QUOTES, 'UTF-8'); ?>">Tổng quan</a>
        <a href="index.php?action=product" id="muc-san-pham" class="<?php echo htmlspecialchars(muc_nav('muc-san-pham', $t), ENT_QUOTES, 'UTF-8'); ?>">Sản phẩm</a>
        <a href="index.php?action=category" id="muc-danh-muc" class="<?php echo htmlspecialchars(muc_nav('muc-danh-muc', $t), ENT_QUOTES, 'UTF-8'); ?>">Danh mục</a>
        <a href="index.php?action=order" id="muc-don-hang" class="<?php echo htmlspecialchars(muc_nav('muc-don-hang', $t), ENT_QUOTES, 'UTF-8'); ?>">Đơn hàng</a>
        <a href="index.php?action=user" id="muc-nguoi-dung" class="<?php echo htmlspecialchars(muc_nav('muc-nguoi-dung', $t), ENT_QUOTES, 'UTF-8'); ?>">Người dùng</a>
        <a href="index.php?action=payment" id="muc-giao-dich" class="<?php echo htmlspecialchars(muc_nav('muc-giao-dich', $t), ENT_QUOTES, 'UTF-8'); ?>">Giao dịch</a>
      </nav>
    </aside>

    <div id="vung-chinh">
<?php if ($action === 'product') : ?>
      <header id="dau-trang">
        <h1 id="tieu-de-trang"><?php echo htmlspecialchars($t['h1'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div id="khu-hanh-dong">
          <button type="button" id="nut-them-sp">Thêm sản phẩm</button>
        </div>
      </header>
<?php else : ?>
      <header id="dau-trang">
        <h1 id="tieu-de-trang"><?php echo htmlspecialchars($t['h1'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div id="khu-chao">
          <span id="loi-chao"></span>
          <button type="button" id="nut-thoat">Đăng xuất</button>
        </div>
      </header>
<?php endif; ?>
