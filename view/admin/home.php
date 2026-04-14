<!-- Nội dung từng trang chỉ thay phần này -->
<main id="noi-dung">
  <div id="khu-thong-ke">
    <article id="the-doanh-thu">
      <p class="gia-tri"><?php echo number_format((float) $tongDoanhThu, 0, ',', '.'); ?></p>
      <p class="nhan">Tổng doanh thu</p>
    </article>
    <article id="the-nguoi-dung">
      <p class="gia-tri"><?php echo $tongNguoiDung; ?></p>
      <p class="nhan">Người dùng</p>
    </article>
    <article id="the-don-hang">
      <p class="gia-tri"><?php echo $tongDonHang; ?></p>
      <p class="nhan">Đơn hàng</p>
    </article>
  </div>

  <section id="hop-bang-don">
    <h2 id="tieu-bang">Đơn gần đây</h2>
    <div id="khung-cuon-bang">
      <table id="bang-du-lieu">
        <thead>
          <tr>
            <th>Số thự tự</th>
            <th>Mã đơn</th>
            <th>Liên lạc</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
          </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($invoiceList as $invoice) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $invoice['invoice_id']; ?></td>
                    <td><?php echo $invoice['phone']; ?></td>
                    <td><?php echo $invoice['total_amount']; ?></td>
                    <td><?php echo $invoice['status_name']; ?></td>
                </tr>
            <?php $i++; ?>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </section>
</main>
