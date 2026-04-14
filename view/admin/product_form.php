<?php
/** @var string $productFormMode 'add'|'edit' */
/** @var array|null $productFormRow hàng Product khi sửa */
/** @var array $categoryList */
$laThem = ($productFormMode === 'add');
$tieuForm = $laThem ? 'Thêm sản phẩm mới' : 'Cập nhật thông tin sản phẩm';
$pid = $laThem ? 0 : (int) ($productFormRow['product_id'] ?? 0);
$ten = $laThem ? '' : (string) ($productFormRow['product_name'] ?? '');
$dmChon = $laThem ? null : ($productFormRow['category_id'] ?? null);
$actionUrl = $laThem
    ? 'index.php?action=product_add'
    : 'index.php?action=product_edit&amp;id=' . $pid;
?>
<main id="noi-dung">
  <div id="vung-bieu-mau-sp">
    <p class="tieu-phu-form"><?php echo htmlspecialchars($tieuForm, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php if ($laThem) { ?>
      <p class="ghi-chu-insert" role="note">Nút <strong>Lưu sản phẩm</strong> sẽ <strong>thêm mới (INSERT)</strong> một dòng vào bảng sản phẩm trên SQL Server.</p>
    <?php } ?>
    <form id="bieu-mau-sp-chinh" class="the-bieu-mau-sp" method="post" action="<?php echo $actionUrl; ?>" accept-charset="UTF-8">
      <?php if ($laThem) { ?>
        <input type="hidden" name="add_product" value="1">
      <?php } else { ?>
        <input type="hidden" name="update_product" value="1">
        <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
      <?php } ?>

      <div class="o-truong">
        <label for="ten-sp-form">Tên sản phẩm</label>
        <input id="ten-sp-form" name="product_name" type="text" required maxlength="255"
          value="<?php echo htmlspecialchars($ten, ENT_QUOTES, 'UTF-8'); ?>"
          placeholder="Ví dụ: Áo thun basic" autocomplete="off" spellcheck="true" lang="vi">
      </div>

      <div class="o-truong">
        <label for="dm-sp-form">Danh mục</label>
        <select id="dm-sp-form" name="category_id" size="8" class="hop-list hop-list-form" aria-label="Danh mục — chọn một mục trong danh sách">
          <option value="0">— Chọn danh mục —</option>
          <?php foreach ($categoryList as $c) {
              $sel = ($dmChon !== null && (int) $dmChon === (int) $c['category_id']) ? ' selected' : '';
              ?>
            <option value="<?php echo (int) $c['category_id']; ?>"<?php echo $sel; ?>><?php echo htmlspecialchars($c['category_name'], ENT_QUOTES, 'UTF-8'); ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="hang-2-nut-form">
        <button type="submit" name="submit_product" value="1" class="nut-gui-form" title="<?php echo $laThem ? 'Thực hiện INSERT sản phẩm' : 'Cập nhật sản phẩm'; ?>"><?php echo $laThem ? 'Lưu sản phẩm' : 'Lưu thay đổi'; ?></button>
        <a class="nut-huy-form" href="index.php?action=product<?php echo $laThem ? '' : '&amp;id=' . $pid; ?>"><?php echo $laThem ? 'Hủy' : 'Hủy và quay lại'; ?></a>
      </div>
    </form>
  </div>
</main>
