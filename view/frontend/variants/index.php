<?php

require_once __DIR__ . '/../layouts/_helpers.php';

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => 'Biến thể sản phẩm',
    'navActive' => 'shop',
));

$list = isset($productVariants) && is_array($productVariants) ? $productVariants : array();

?>
<section class="product-page">
    <div class="container">
        <div class="section-header">
            <h2>Danh sách biến thể</h2>
            <p><a href="<?php echo htmlspecialchars(app_route('product')); ?>">← Cửa hàng</a></p>
        </div>

<?php if (empty($list)) { ?>
        <p>Chưa có biến thể nào.</p>
<?php } else { ?>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:640px;">
                <thead>
                    <tr style="text-align:left;">
                        <th style="padding:.5rem;">ID</th>
                        <th style="padding:.5rem;">product_id</th>
                        <th style="padding:.5rem;">Size</th>
                        <th style="padding:.5rem;">Màu</th>
                        <th style="padding:.5rem;">Giá</th>
                        <th style="padding:.5rem;">Ảnh</th>
                        <th style="padding:.5rem;"></th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($list as $row) {
        $vid = layout_row_int($row, array('id', 'variant_id', 'varient_id'));
        $pid = layout_row_int($row, array('product_id'));
?>
                    <tr>
                        <td style="padding:.5rem;"><?php echo $vid; ?></td>
                        <td style="padding:.5rem;"><?php echo $pid; ?></td>
                        <td style="padding:.5rem;"><?php echo htmlspecialchars(layout_row_str($row, array('size'), ''), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td style="padding:.5rem;"><?php echo htmlspecialchars(layout_row_str($row, array('color'), ''), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td style="padding:.5rem;"><?php echo number_format((int) ($row['price'] ?? 0), 0, ',', '.'); ?></td>
                        <td style="padding:.5rem;">
<?php
        $img = layout_row_str($row, array('image'), '');
        if ($img !== '') {
            echo '<img src="' . htmlspecialchars($img, ENT_QUOTES, 'UTF-8') . '" alt="" width="40">';
        }
?>
                        </td>
                        <td style="padding:.5rem;">
                            <a href="<?php echo htmlspecialchars(app_route('product', 'show', array('product_id' => $pid))); ?>">Sản phẩm</a>
                        </td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div>
<?php } ?>
    </div>
</section>
<?php
$this->view('frontend.layouts.footer');
?>
