<!-- Nội dung trang Quản lý đơn hàng — include sau header -->
<main id="noi-dung">
  <div id="ket-qua">
    <div id="hang-tim-don">
      <form id="bieu-mau-tim" action="#" method="get">
        <input type="search" id="o-tim-don" name="q" placeholder="" autocomplete="off" aria-label="Tìm đơn hàng">
        <button type="submit" id="nut-tim-don">Tìm kiếm</button>
      </form>
    </div>

    <div id="hop-bang-don-chinh">
      <div id="khung-keo-bang-don">
        <table id="bang-don-hang">
          <thead>
            <tr>
              <th>Mã hóa đơn</th>
              <th>Mã khách hàng</th>
              <th>Địa chỉ</th>
              <th>Số điện thoại</th>
              <th>Ghi chú</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <section id="chi-tiet-don" aria-labelledby="tieu-chi-don">
      <h2 id="tieu-chi-don">Chi tiết đơn hàng: <span id="ma-don-chon"></span></h2>
      <div id="hop-bang-ct">
        <div id="khung-keo-ct">
          <table id="bang-ct-don">
            <thead>
              <tr>
                <th>Tên sản phẩm</th>
                <th>Biến thể</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <div id="hang-tong-don">
          <span id="nhan-tong">Tổng cộng:</span>
          <strong id="gia-tri-tong"></strong>
        </div>
      </div>
    </section>
  </div>
</main>
