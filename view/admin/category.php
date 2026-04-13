<!-- Nội dung trang Quản lý danh mục — include sau header -->
<main id="noi-dung">
  <div id="khu-danh-muc">
    <div id="hang-tren-dm">
      <h2 id="tieu-noi-dm">Quản lý Danh mục</h2>
      <button type="button" id="nut-them-dm">Thêm danh mục</button>
    </div>

    <div id="hop-ds-dm">
      <ul id="ds-danh-muc"></ul>
    </div>

    <section id="form-dm" aria-labelledby="tieu-form-dm">
      <h3 id="tieu-form-dm">Thêm danh mục</h3>
      <form id="bieu-mau-dm" action="#" method="post">
        <div id="o-nhom-ten">
          <label id="nhan-ten-dm" for="o-ten-dm">Tên danh mục</label>
          <input type="text" id="o-ten-dm" name="ten_dm" autocomplete="off">
        </div>
        <div id="hang-nut-dm">
          <button type="submit" id="nut-luu-dm">Lưu</button>
          <button type="button" id="nut-huy-dm">Hủy</button>
        </div>
      </form>
    </section>
  </div>
</main>
