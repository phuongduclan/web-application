<?php
$ma_loi = isset($_GET['err']) ? preg_replace('/[^a-z0-9_]/i', '', (string) $_GET['err']) : '';
?>
<main id="noi-dung">
  <?php if ($ma_loi === 'fk_category') { ?>
    <div class="thong-bao-khong-xoa" role="status">
      <p class="tieu-thong-bao">Không thể xóa danh mục</p>
    </div>
  <?php } ?>
  <div id="khu-danh-muc">
    <div id="hang-tren-dm">
      <h2 id="tieu-noi-dm">Danh sách danh mục</h2>
    </div>

    <div id="hop-ds-dm">
      <ul id="ds-danh-muc">
        <?php if (empty($categoryList)) { ?>
          <li class="the-dm rong-dm"><span class="ten-dm">Chưa có danh mục. Thêm bằng nút bên trên.</span></li>
        <?php } ?>
        <?php $stt = 1; ?>
        <?php foreach ($categoryList as $row) {
            $cid = (int) $row['category_id'];
            $ten = (string) ($row['category_name'] ?? '');
            ?>
          <li class="the-dm">
            <span class="ma-dm"><?php echo $stt; ?></span>
            <span class="ten-dm"><?php echo htmlspecialchars($ten, ENT_QUOTES, 'UTF-8'); ?></span>
            <div class="hanh-dm">
              <a class="lk-sua" href="index.php?action=category_edit&amp;id=<?php echo $cid; ?>">Sửa</a>
              <form class="bieu-xoa-dm bieu-can-xac-nhan" method="post" action="index.php?action=category" accept-charset="UTF-8"
                data-confirm="<?php echo htmlspecialchars('Xóa danh mục «' . $ten . '»?', ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="delete_category" value="1">
                <input type="hidden" name="category_id" value="<?php echo $cid; ?>">
                <button type="submit" class="lk-xoa">Xóa</button>
              </form>
            </div>
          </li>
        <?php $stt++; ?>
        <?php } ?>
      </ul>
    </div>
  </div>
</main>
