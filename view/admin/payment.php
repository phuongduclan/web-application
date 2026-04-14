<?php
/**
 * Quản lý giao dịch — Figma 2:1141 (USP_ListAllPayment / USP_SearchPaymentByInvoice).
 *
 * @var array<int, array<string, mixed>> $paymentList
 * @var string $tuKhoaHoaDon
 * @var int $tongSoGiaoDich
 * @var int $tongThuGiaoDich
 */
$paymentList = $paymentList ?? [];
$tuKhoaHoaDon = $tuKhoaHoaDon ?? '';
$tongSoGiaoDich = (int) ($tongSoGiaoDich ?? 0);
$tongThuGiaoDich = (int) ($tongThuGiaoDich ?? 0);

$fmtVnd = static function (int $amount): string {
    return number_format($amount, 0, ',', '.') . 'đ';
};

$fmtNgay = static function ($raw): string {
    if ($raw === null || $raw === '') {
        return '—';
    }
    $s = trim((string) $raw);
    if (preg_match('/^\d{4}-\d{2}-\d{2}/', $s)) {
        $t = strtotime(substr($s, 0, 10));
        return $t !== false ? date('d/m/Y', $t) : htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }
    $t = strtotime($s);
    return $t !== false ? date('d/m/Y', $t) : htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
};
?>
<main id="noi-dung">
  <div id="ket-qua">
    <div id="hang-dieu-khien-gd">
      <form id="bieu-mau-tim-gd" method="get" action="index.php">
        <input type="hidden" name="action" value="payment">
        <label class="sr-only" for="o-tim-gd">Tìm theo mã hóa đơn</label>
        <input type="search" id="o-tim-gd" name="q" value="<?php echo htmlspecialchars($tuKhoaHoaDon, ENT_QUOTES, 'UTF-8'); ?>"
          placeholder="Nhập mã hóa đơn…" inputmode="numeric" autocomplete="off" aria-label="Tìm giao dịch theo mã hóa đơn">
        <button type="submit" id="nut-tim-gd">Tìm kiếm</button>
      </form>
      <p id="tom-tat-gd">
        <span class="muc-tom">Tổng giao dịch: <strong id="so-giao-dich"><?php echo $tongSoGiaoDich; ?></strong></span>
        <span class="phan-cach" aria-hidden="true">|</span>
        <span class="muc-tom">Tổng thu: <strong id="tong-thu"><?php echo $fmtVnd($tongThuGiaoDich); ?></strong></span>
      </p>
    </div>

    <div id="hop-bang-gd">
      <div id="khung-keo-bang-gd">
        <table id="bang-giao-dich">
          <thead>
            <tr>
              <th scope="col">Mã thanh toán</th>
              <th scope="col">Mã hóa đơn</th>
              <th scope="col">Ngày thanh toán</th>
              <th scope="col">Số tiền</th>
              <th scope="col">Phương thức thanh toán</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($paymentList)) { ?>
              <tr>
                <td colspan="5" class="o-trong-bang-gd">Không có giao dịch<?php echo ($tuKhoaHoaDon !== '' ? ' cho mã hóa đơn này.' : '.'); ?></td>
              </tr>
            <?php } ?>
            <?php foreach ($paymentList as $row) {
                $pid = (int) ($row['payment_id'] ?? 0);
                $iid = (int) ($row['invoice_id'] ?? 0);
                $method = (string) ($row['method_name'] ?? '');
                $amt = (int) ($row['payment_amount'] ?? 0);
                ?>
              <tr>
                <td><?php echo $pid; ?></td>
                <td><?php echo $iid; ?></td>
                <td><?php echo $fmtNgay($row['payment_date'] ?? null); ?></td>
                <td><?php echo $fmtVnd($amt); ?></td>
                <td><?php echo htmlspecialchars($method, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
