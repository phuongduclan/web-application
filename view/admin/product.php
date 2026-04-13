<!-- Nội dung trang Quản lý sản phẩm — include sau header -->
<main id="noi-dung">
  <div id="giao-san-pham">
    <div id="cot-danh-sach">
      <div id="khung-keo-ds">
        <ul id="ds-the-sp"></ul>
      </div>
    </div>

    <div id="cot-chi-tiet">
      <div id="hop-chi-tiet">
        <section id="tt-san-pham" aria-label="Thông tin sản phẩm">
          <div class="dong-tt" id="dong-ma-sp">
            <span class="nhan-tt">Mã SP:</span>
            <span class="gia-tri" id="gia-tri-ma"></span>
          </div>
          <div class="dong-tt" id="dong-ten-sp">
            <span class="nhan-tt">Tên:</span>
            <span class="gia-tri" id="gia-tri-ten"></span>
          </div>
          <div class="dong-tt" id="dong-danh-muc">
            <span class="nhan-tt">Danh mục:</span>
            <span class="gia-tri" id="gia-tri-dm"></span>
          </div>
          <div class="dong-tt" id="dong-mo-ta">
            <span class="nhan-tt">Mô tả:</span>
            <span class="gia-tri" id="gia-tri-mt"></span>
          </div>
        </section>

        <section id="khu-bien-the" aria-label="Biến thể">
          <div id="hang-tieu-bien">
            <h2 id="tieu-ds-bien">Danh sách biến thể</h2>
            <button type="button" id="nut-them-bien">Thêm biến thể</button>
          </div>
          <div id="khung-bang-bien">
            <table id="bang-bien-the">
              <thead>
                <tr>
                  <th>Kích cỡ</th>
                  <th>Màu sắc</th>
                  <th>Giá</th>
                  <th>Ảnh (URL)</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </section>
      </div>
    </div>
  </div>
</main>
