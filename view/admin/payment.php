<!-- Nội dung trang Quản lý giao dịch — include sau header -->
<main id="noi-dung">
  <div id="ket-qua">
    <div id="hang-dieu-khien-gd">
      <form id="bieu-mau-tim-gd" action="#" method="get">
        <input type="search" id="o-tim-gd" name="q" placeholder="" autocomplete="off" aria-label="Tìm giao dịch">
        <button type="submit" id="nut-tim-gd">Tìm kiếm</button>
      </form>
      <p id="tom-tat-gd">
        <span class="muc-tom">Tổng giao dịch: <strong id="so-giao-dich"></strong></span>
        <span class="phan-cach" aria-hidden="true">|</span>
        <span class="muc-tom">Tổng thu: <strong id="tong-thu"></strong></span>
      </p>
    </div>

    <div id="hop-bang-gd">
      <div id="khung-keo-bang-gd">
        <table id="bang-giao-dich">
          <thead>
            <tr>
              <th>Mã thanh toán</th>
              <th>Mã hóa đơn</th>
              <th>Ngày thanh toán</th>
              <th>Số tiền</th>
              <th>Phương thức thanh toán</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</main>
