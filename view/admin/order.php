<?php
/**
 * Quản lý đơn hàng — Figma 2:797; cập nhật trạng thái qua USP_UpdateInvoiceStatus (chỉ từ trạng thái 1).
 *
 * @var array<int, array<string, mixed>> $orderList
 * @var int $selectedOrderId
 * @var array<int, array<string, mixed>> $orderDetailLines
 * @var int $orderDetailTotal
 * @var string $tuKhoaTimDon
 */
$orderList = $orderList ?? [];
$selectedOrderId = (int) ($selectedOrderId ?? 0);
$orderDetailLines = $orderDetailLines ?? [];
$orderDetailTotal = (int) ($orderDetailTotal ?? 0);
$tuKhoaTimDon = $tuKhoaTimDon ?? '';

$fmtVnd = static function ($amount): string {
    return number_format((int) $amount, 0, ',', '.') . 'đ';
};

/** Hiển thị theo Figma; DB seed: 1 Chưa xử lý → «Chờ xử lý». */
$nhanTrangThai = static function (int $statusId, ?string $statusName): array {
    if ($statusId === 1) {
        return ['label' => 'Chờ xử lý', 'lop' => 'tt-cho-xu-ly'];
    }
    if ($statusId === 2) {
        return ['label' => 'Đã xác nhận', 'lop' => 'tt-da-xac-nhan'];
    }
    if ($statusId === 3) {
        return ['label' => 'Đã hủy', 'lop' => 'tt-da-huy'];
    }
    $name = trim((string) $statusName);
    return ['label' => $name !== '' ? $name : '—', 'lop' => 'tt-cho-xu-ly'];
};

$maLoi = isset($_GET['err']) ? preg_replace('/[^a-z0-9_]/i', '', (string) $_GET['err']) : '';
?>
<main id="noi-dung">
  <div id="ket-qua">
    <?php if ($maLoi === 'order_update') { ?>
      <div class="thong-bao-don-loi" role="status">
        <p>Không thể cập nhật trạng thái. Chỉ đơn <strong>Chờ xử lý</strong> mới được xác nhận hoặc hủy.</p>
      </div>
    <?php } ?>

    <div id="hang-tim-don">
      <form id="bieu-mau-tim" method="get" action="index.php">
        <input type="hidden" name="action" value="order">
        <label class="sr-only" for="o-tim-don">Tìm đơn hàng</label>
        <input type="search" id="o-tim-don" name="q" value="<?php echo htmlspecialchars($tuKhoaTimDon, ENT_QUOTES, 'UTF-8'); ?>"
          placeholder="SĐT, mã đơn, mã KH, địa chỉ…" autocomplete="off" aria-label="Tìm đơn hàng">
        <button type="submit" id="nut-tim-don">Tìm kiếm</button>
      </form>
    </div>

    <div id="hop-bang-don-chinh">
      <div id="khung-keo-bang-don">
        <table id="bang-don-hang">
          <thead>
            <tr>
              <th scope="col">Mã hóa đơn</th>
              <th scope="col">Mã khách hàng</th>
              <th scope="col">Địa chỉ</th>
              <th scope="col">Số điện thoại</th>
              <th scope="col">Ghi chú</th>
              <th scope="col">Tổng tiền</th>
              <th scope="col">Trạng thái</th>
              <th scope="col">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($orderList)) { ?>
              <tr>
                <td colspan="8" class="o-trong-bang-don">Không có đơn hàng.</td>
              </tr>
            <?php } ?>
            <?php foreach ($orderList as $row) {
                $iid = (int) ($row['invoice_id'] ?? 0);
                $uid = (int) ($row['user_id'] ?? 0);
                $dc = trim((string) ($row['address'] ?? ''));
                $phone = trim((string) ($row['phone'] ?? ''));
                $note = trim((string) ($row['note'] ?? ''));
                $tong = (int) ($row['total_amount'] ?? 0);
                $sid = (int) ($row['status_id'] ?? 0);
                $tt = $nhanTrangThai($sid, isset($row['status_name']) ? (string) $row['status_name'] : null);
                $coTheSua = ($sid === 1);
                ?>
              <tr class="dong-don<?php echo ($iid === $selectedOrderId) ? ' dong-don-chon' : ''; ?>">
                <td>
                  <a class="lk-ma-don" href="index.php?action=order&amp;id=<?php echo $iid; ?><?php echo $tuKhoaTimDon !== '' ? '&amp;q=' . rawurlencode($tuKhoaTimDon) : ''; ?>"><?php echo $iid; ?></a>
                </td>
                <td><?php echo $uid; ?></td>
                <td class="o-dc-don"><?php echo htmlspecialchars($dc, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="o-ghi-chu-don"><?php echo $note !== '' ? htmlspecialchars($note, ENT_QUOTES, 'UTF-8') : '—'; ?></td>
                <td><?php echo $fmtVnd($tong); ?></td>
                <td><span class="<?php echo htmlspecialchars($tt['lop'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($tt['label'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                <td class="cell-hanh">
                  <?php if ($coTheSua) { ?>
                    <form method="post" action="index.php?action=order&amp;id=<?php echo $iid; ?>" class="bieu-hanh-don">
                      <input type="hidden" name="invoice_id" value="<?php echo $iid; ?>">
                      <button type="submit" name="confirm_order" value="1" class="nut-xac-don">Xác nhận</button>
                    </form>
                    <form method="post" action="index.php?action=order&amp;id=<?php echo $iid; ?>" class="bieu-hanh-don">
                      <input type="hidden" name="invoice_id" value="<?php echo $iid; ?>">
                      <button type="submit" name="cancel_order" value="1" class="nut-huy-don">Hủy đơn hàng</button>
                    </form>
                  <?php } else { ?>
                    <span class="dau-gach-ngang">—</span>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <section id="chi-tiet-don" aria-labelledby="tieu-chi-don">
      <h2 id="tieu-chi-don">Chi tiết đơn hàng: <span id="ma-don-chon"><?php echo $selectedOrderId > 0 ? (int) $selectedOrderId : '—'; ?></span></h2>
      <div id="hop-bang-ct">
        <div id="khung-keo-ct">
          <table id="bang-ct-don">
            <thead>
              <tr>
                <th scope="col">Số thự tự</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Biến thể</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Đơn giá</th>
                <th scope="col">Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($selectedOrderId <= 0) { ?>
                <tr>
                  <td colspan="6" class="o-trong-bang-don">Chọn đơn hoặc tìm kiếm để xem chi tiết.</td>
                </tr>
              <?php } elseif (empty($orderDetailLines)) { ?>
                <tr>
                  <td colspan="6" class="o-trong-bang-don">Không có dòng chi tiết cho đơn này.</td>
                </tr>
              <?php } ?>
              <?php foreach ($orderDetailLines as $line) { ?>
                <tr>
                  <td><?php echo (int) ($line['stt'] ?? 0); ?></td>
                  <td><?php echo htmlspecialchars((string) ($line['product_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars((string) ($line['variant'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo (int) ($line['quantity'] ?? 0); ?></td>
                  <td><?php echo $fmtVnd((int) ($line['price'] ?? 0)); ?></td>
                  <td><?php echo $fmtVnd((int) ($line['total'] ?? 0)); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div id="hang-tong-don">
          <span id="nhan-tong">Tổng cộng:</span>
          <strong id="gia-tri-tong"><?php echo $selectedOrderId > 0 ? $fmtVnd($orderDetailTotal) : '—'; ?></strong>
        </div>
      </div>
    </section>
  </div>
</main>
