<?php
$dinh_dang_gia = static function ($v) {
    if ($v === null || $v === '') {
        return '—';
    }
    return number_format((float) $v, 0, ',', '.') . 'đ';
};
$ma_loi = isset($_GET['err']) ? preg_replace('/[^a-z0-9_]/i', '', (string) $_GET['err']) : '';
?>
<!-- Nội dung trang Quản lý sản phẩm (Figma node 2:259) -->
<main id="noi-dung">
  <?php if ($ma_loi === 'fk_product') { ?>
    <div class="thong-bao-khong-xoa" role="status">
      <p class="tieu-thong-bao">Không thể xóa sản phẩm</p>
    </div>
  <?php } elseif ($ma_loi === 'fk_variant') { ?>
    <div class="thong-bao-khong-xoa" role="status">
      <p class="tieu-thong-bao">Không thể xóa biến thể</p>
      <p class="noi-dung-thong-bao">Biến thể này đang được tham chiếu ở bảng khác (ví dụ chi tiết đơn hàng). Khóa ngoại không cho phép xóa — đây là hành vi đúng. Vui lòng điều chỉnh hoặc gỡ các bản ghi liên quan trước khi thử lại.</p>
    </div>
  <?php } ?>
  <div id="giao-san-pham">

    <!-- Cột trái: danh sách (thêm SP: nút trên header → trang product_add) -->
    <div id="cot-danh-sach">
      <div id="khung-keo-ds">
        <ul id="ds-the-sp">
          <?php if (empty($productList)) { ?>
            <li class="rong-ds"><p class="goi-y-chon">Chưa có sản phẩm.</p></li>
          <?php } ?>
          <?php $stt = 1; ?>
          <?php foreach ($productList as $p) {
              $pid = (int) $p['product_id'];
              $dang = ($selectedId > 0 && $selectedId === $pid) ? ' the-sp dang-chon' : ' the-sp';
              ?>
            <li class="<?php echo trim($dang); ?>">
              <span class="stt-sp"><?php echo $stt; ?></span>
              <div class="ten-dong">
                <a class="ten-sp lk-chon-sp" href="?action=product&amp;id=<?php echo $pid; ?>" title="Xem chi tiết: <?php echo htmlspecialchars($p['product_name'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($p['product_name'], ENT_QUOTES, 'UTF-8'); ?></a>
                <span class="ten-loai"><?php echo htmlspecialchars($p['category_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
              </div>
              <div class="hanh-sp">
                <a class="lk-sua" href="index.php?action=product_edit&amp;id=<?php echo $pid; ?>" title="Cập nhật sản phẩm: <?php echo htmlspecialchars($p['product_name'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Cập nhật sản phẩm <?php echo htmlspecialchars($p['product_name'], ENT_QUOTES, 'UTF-8'); ?>">Sửa</a>
                <form class="bieu-xoa-sp bieu-can-xac-nhan" method="post" action="index.php?action=product" accept-charset="UTF-8" data-confirm="<?php echo htmlspecialchars('Bạn có chắc muốn xóa sản phẩm «' . ($p['product_name'] ?? '') . '»? Thao tác này không thể hoàn tác.', ENT_QUOTES, 'UTF-8'); ?>">
                  <input type="hidden" name="delete_product" value="1">
                  <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
                  <button type="submit" class="lk-xoa" title="Xóa vĩnh viễn sản phẩm này" aria-label="Xóa sản phẩm <?php echo htmlspecialchars($p['product_name'], ENT_QUOTES, 'UTF-8'); ?>">Xóa</button>
                </form>
              </div>
            </li>
          <?php $stt++; ?>
          <?php } ?>
        </ul>
      </div>
    </div>

    <!-- Cột phải: chi tiết -->
    <div id="cot-chi-tiet">
      <?php if ($selectedId <= 0 || $productDetail === null) { ?>
        <div id="hop-chi-tiet">
          <p class="goi-y-chon">Chọn một sản phẩm ở cột trái để xem chi tiết và quản lý biến thể.</p>
        </div>
      <?php } else { ?>
        <div id="hop-chi-tiet">

          <section id="tt-san-pham">
            <div class="dong-tt">
              <span class="nhan-tt">Mã SP:</span>
              <span class="gia-tri"><?php echo (int) $productDetail['product_id']; ?></span>
            </div>
            <div class="dong-tt">
              <span class="nhan-tt">Tên:</span>
              <span class="gia-tri"><?php echo htmlspecialchars($productDetail['product_name'], ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="dong-tt">
              <span class="nhan-tt">Danh mục:</span>
              <span class="gia-tri"><?php echo htmlspecialchars($productDetail['category_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="hang-nut-tt hang-nut-chinh-xem">
              <a class="nut-chinh-sua-sp" href="index.php?action=product_edit&amp;id=<?php echo (int) $productDetail['product_id']; ?>">Chỉnh sửa thông tin</a>
            </div>
          </section>

          <section id="khu-bien-the">
            <div id="hang-tieu-bien">
              <h2 id="tieu-ds-bien">Danh sách biến thể</h2>
              <a href="#them-bien-the" id="nut-them-bien">Thêm biến thể</a>
            </div>

            <div id="them-bien-the" class="hop-them-sp khu-form-bien">
              <p class="tieu-nho">Thêm biến thể mới</p>
              <form class="bieu-mau-ngan bieu-bien-the" method="post" action="index.php?action=product&amp;id=<?php echo (int) $productDetail['product_id']; ?>" accept-charset="UTF-8">
                <input type="hidden" name="add_variant" value="1">
                <input type="hidden" name="product_id" value="<?php echo (int) $productDetail['product_id']; ?>">
                <label for="kc-bien-moi">Kích cỡ <span class="goi-y-nho">(tự nhập, tối đa 10 ký tự)</span></label>
                <input id="kc-bien-moi" name="size" type="text" class="o-nhap-bien" required maxlength="10" placeholder="VD: M, L, Free size" autocomplete="off" lang="vi" spellcheck="false" aria-label="Kích cỡ biến thể">
                <label for="mau-bien-moi">Màu sắc <span class="goi-y-nho">(tự nhập, tối đa 100 ký tự)</span></label>
                <input id="mau-bien-moi" name="color" type="text" class="o-nhap-bien" required maxlength="100" placeholder="VD: Đen, Xám tro" autocomplete="off" lang="vi" spellcheck="true" aria-label="Màu sắc biến thể">
                <label for="gia-bien-moi">Giá (VNĐ)</label>
                <input id="gia-bien-moi" name="price" type="number" min="0" step="1" required placeholder="150000">
                <label for="anh-bien-moi">Ảnh (URL)</label>
                <input id="anh-bien-moi" name="image" type="text" maxlength="255" placeholder="/img/ao-den-s.jpg" lang="vi">
                <button type="submit" title="Thêm bản ghi biến thể (INSERT)">Thêm biến thể</button>
              </form>
            </div>

            <?php if ($variantEditRow !== null) { ?>
            <div class="hop-them-sp khu-form-bien">
              <p class="tieu-nho">Sửa biến thể</p>
              <form class="bieu-mau-ngan bieu-bien-the" method="post" action="index.php?action=product&amp;id=<?php echo (int) $productDetail['product_id']; ?>" accept-charset="UTF-8">
                <input type="hidden" name="update_variant" value="1">
                <input type="hidden" name="product_id" value="<?php echo (int) $productDetail['product_id']; ?>">
                <input type="hidden" name="variant_id" value="<?php echo (int) ($variantEditRow['variant_id'] ?? 0); ?>">
                <label for="kc-bien-sua">Kích cỡ <span class="goi-y-nho">(tối đa 10 ký tự)</span></label>
                <input id="kc-bien-sua" name="size" type="text" class="o-nhap-bien" required maxlength="10" value="<?php echo htmlspecialchars(trim((string) ($variantEditRow['size'] ?? '')), ENT_QUOTES, 'UTF-8'); ?>" lang="vi" spellcheck="false" aria-label="Kích cỡ">
                <label for="mau-bien-sua">Màu sắc <span class="goi-y-nho">(tối đa 100 ký tự)</span></label>
                <input id="mau-bien-sua" name="color" type="text" class="o-nhap-bien" required maxlength="100" value="<?php echo htmlspecialchars(trim((string) ($variantEditRow['color'] ?? '')), ENT_QUOTES, 'UTF-8'); ?>" lang="vi" spellcheck="true" aria-label="Màu sắc">
                <label for="gia-bien-sua">Giá (VNĐ)</label>
                <input id="gia-bien-sua" name="price" type="number" min="0" step="1" required value="<?php echo (int) ($variantEditRow['price'] ?? 0); ?>">
                <label for="anh-bien-sua">Ảnh (URL)</label>
                <input id="anh-bien-sua" name="image" type="text" maxlength="255" value="<?php echo htmlspecialchars((string) ($variantEditRow['image'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" lang="vi">
                <div class="hang-nut-tt">
                  <button type="submit" title="Cập nhật bản ghi biến thể">Cập nhật biến thể</button>
                  <a class="lk-huy" href="index.php?action=product&amp;id=<?php echo (int) $productDetail['product_id']; ?>" title="Hủy sửa biến thể">Hủy</a>
                </div>
              </form>
            </div>
            <?php } ?>

            <div id="khung-bang-bien">
              <table id="bang-bien-the">
                <thead>
                  <tr>
                    <th scope="col">Kích cỡ</th>
                    <th scope="col">Màu sắc</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Ảnh (đường dẫn)</th>
                    <th scope="col">Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($variantList)) { ?>
                    <?php foreach ($variantList as $v) {
                        $vid = (int) ($v['variant_id'] ?? 0);
                        $img = trim((string) ($v['image'] ?? ''));
                        ?>
                      <tr>
                        <td><?php echo htmlspecialchars((string) ($v['size'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars((string) ($v['color'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($dinh_dang_gia($v['price'] ?? null), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="o-anh-url">
                          <?php if ($img !== '') { ?>
                            <span class="chuoi-anh" title="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?></span>
                            <img src="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="Ảnh minh họa biến thể" width="48" height="48" class="thumb-bien" loading="lazy" decoding="async">
                          <?php } else { ?>
                            —
                          <?php } ?>
                        </td>
                        <td class="o-hanh">
                          <?php
                            $nhan_bt = trim((string) ($v['size'] ?? '') . ' · ' . (string) ($v['color'] ?? ''));
                          ?>
                          <a class="lk-sua" href="index.php?action=product&amp;id=<?php echo (int) $productDetail['product_id']; ?>&amp;variant_edit=<?php echo $vid; ?>" title="Sửa biến thể: <?php echo htmlspecialchars($nhan_bt, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Sửa biến thể <?php echo htmlspecialchars($nhan_bt, ENT_QUOTES, 'UTF-8'); ?>">Sửa</a>
                          <form method="post" action="index.php?action=product&amp;id=<?php echo (int) $productDetail['product_id']; ?>" class="bieu-xoa-bien bieu-can-xac-nhan" accept-charset="UTF-8" data-confirm="<?php echo htmlspecialchars('Xóa biến thể «' . $nhan_bt . '»? Thao tác này không thể hoàn tác.', ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="delete_variant" value="1">
                            <input type="hidden" name="product_id" value="<?php echo (int) $productDetail['product_id']; ?>">
                            <input type="hidden" name="variant_id" value="<?php echo $vid; ?>">
                            <button type="submit" class="lk-xoa" title="Xóa biến thể này" aria-label="Xóa biến thể <?php echo htmlspecialchars($nhan_bt, ENT_QUOTES, 'UTF-8'); ?>">Xóa</button>
                          </form>
                        </td>
                      </tr>
                    <?php } ?>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5">Chưa có biến thể</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </section>

        </div>
      <?php } ?>
    </div>

  </div>
</main>
