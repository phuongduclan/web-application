<?php
/** @var string $categoryFormMode 'add'|'edit' */
/** @var array|null $categoryFormRow */
$laThem = ($categoryFormMode === 'add');
$cid = $laThem ? 0 : (int) ($categoryFormRow['category_id'] ?? 0);
$ten = $laThem ? '' : (string) ($categoryFormRow['category_name'] ?? '');
$actionUrl = $laThem
    ? 'index.php?action=category_add'
    : 'index.php?action=category_edit&amp;id=' . $cid;
?>
<main id="noi-dung">
  <div id="vung-bieu-mau-dm">
    <p class="tieu-phu-form"><?php echo $laThem ? 'Thêm danh mục mới' : 'Cập nhật danh mục'; ?></p>
    <form id="bieu-mau-dm-chinh" class="the-bieu-mau-sp" method="post" action="<?php echo $actionUrl; ?>" accept-charset="UTF-8">
      <?php if ($laThem) { ?>
        <input type="hidden" name="add_category" value="1">
      <?php } else { ?>
        <input type="hidden" name="update_category" value="1">
        <input type="hidden" name="category_id" value="<?php echo $cid; ?>">
      <?php } ?>
      <div class="o-truong">
        <label for="ten-dm-form">Tên danh mục</label>
        <input id="ten-dm-form" name="category_name" type="text" required maxlength="255"
          value="<?php echo htmlspecialchars($ten, ENT_QUOTES, 'UTF-8'); ?>"
          placeholder="Ví dụ: Áo, Quần" autocomplete="off" spellcheck="true" lang="vi">
      </div>
      <div class="hang-2-nut-form hang-nut-dm-inline">
        <button type="submit" class="nut-gui-form"><?php echo $laThem ? 'Lưu' : 'Lưu thay đổi'; ?></button>
        <a class="nut-huy-form" href="index.php?action=category">Hủy</a>
      </div>
    </form>
  </div>
</main>
