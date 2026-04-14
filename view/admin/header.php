<?php
/** $action do index.php gán; fallback nếu include header đứng một mình (không nên) */
$action = $action ?? 'home';
$thiet_lap_trang = [
    'home'     => ['page_title' => 'Tổng quan — Admin', 'h1' => 'Tổng quan', 'nav' => 'muc-tong-quan'],
    'product'  => ['page_title' => 'Quản lý Sản phẩm — Admin', 'h1' => 'Quản lý Sản phẩm', 'nav' => 'muc-san-pham'],
    'product_add' => ['page_title' => 'Thêm sản phẩm — Admin', 'h1' => 'Thêm sản phẩm', 'nav' => 'muc-san-pham'],
    'product_edit' => ['page_title' => 'Cập nhật sản phẩm — Admin', 'h1' => 'Cập nhật sản phẩm', 'nav' => 'muc-san-pham'],
    'category' => ['page_title' => 'Quản lý Danh mục — Admin', 'h1' => 'Quản lý Danh mục', 'nav' => 'muc-danh-muc'],
    'category_add' => ['page_title' => 'Thêm danh mục — Admin', 'h1' => 'Thêm danh mục', 'nav' => 'muc-danh-muc'],
    'category_edit' => ['page_title' => 'Cập nhật danh mục — Admin', 'h1' => 'Cập nhật danh mục', 'nav' => 'muc-danh-muc'],
    'order'    => ['page_title' => 'Quản lý Đơn hàng — Admin', 'h1' => 'Quản lý Đơn hàng', 'nav' => 'muc-don-hang'],
    'user'     => ['page_title' => 'Quản lý Người dùng — Admin', 'h1' => 'Quản lý Người dùng', 'nav' => 'muc-nguoi-dung'],
    'payment'  => ['page_title' => 'Quản lý Giao dịch — Admin', 'h1' => 'Quản lý Giao dịch', 'nav' => 'muc-giao-dich'],
];

$t = $thiet_lap_trang[$action] ?? $thiet_lap_trang['home'];

$lop_body_phu = [
    'product'  => 'trang-san-pham',
    'product_add' => 'trang-san-pham trang-bieu-mau-sp',
    'product_edit' => 'trang-san-pham trang-bieu-mau-sp',
    'category' => 'trang-danh-muc',
    'category_add' => 'trang-danh-muc trang-bieu-mau-sp',
    'category_edit' => 'trang-danh-muc trang-bieu-mau-sp',
    'order'    => 'trang-don-hang',
    'user'     => 'trang-nguoi-dung',
    'payment'  => 'trang-giao-dich',
];
$lop_body = $lop_body_phu[$action] ?? '';

/** Chữ logo sidebar (có thể gán trước khi include header, ví dụ từ index.php) */
$chu_logo = $chu_logo ?? 'ADMIN';

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
  <meta http-equiv="Content-Language" content="vi">
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
          <a href="index.php?action=product_add" id="nut-them-sp">Thêm sản phẩm</a>
        </div>
      </header>
<?php elseif ($action === 'category') : ?>
      <header id="dau-trang">
        <h1 id="tieu-de-trang"><?php echo htmlspecialchars($t['h1'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div id="khu-hanh-dong">
          <a href="index.php?action=category_add" id="nut-them-dm">Thêm danh mục</a>
        </div>
      </header>
<?php elseif ($action === 'category_add' || $action === 'category_edit') : ?>
      <header id="dau-trang">
        <h1 id="tieu-de-trang"><?php echo htmlspecialchars($t['h1'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div id="khu-hanh-dong">
          <a href="index.php?action=category" class="lk-quay-lai-ds">← Quay lại danh sách</a>
        </div>
      </header>
<?php elseif ($action === 'product_add' || $action === 'product_edit') : ?>
      <header id="dau-trang">
        <h1 id="tieu-de-trang"><?php echo htmlspecialchars($t['h1'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div id="khu-hanh-dong">
          <a href="index.php?action=product" class="lk-quay-lai-ds">← Quay lại danh sách</a>
        </div>
      </header>
<?php else : ?>
      <header id="dau-trang">
        <h1 id="tieu-de-trang"><?php echo htmlspecialchars($t['h1'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div id="khu-chao">
          <span id="loi-chao">Xin chào, Admin</span>
          <button type="button" id="nut-thoat">Đăng xuất</button>
        </div>
      </header>
<?php endif; ?>
