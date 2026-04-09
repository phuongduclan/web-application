<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ hàng - Shop.co</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>
  <main class="cart-page">
    <section class="cart-panel" aria-label="Giỏ hàng">
      <h1 class="page-title">Giỏ hàng của bạn</h1>
      <section class="catalog-panel" aria-label="Sản phẩm có sẵn">
        <h2>Sản phẩm có sẵn</h2>
        <div id="productCatalog" class="catalog-grid"></div>
      </section>

      <div id="cartItems" class="items-list"></div>
    </section>

    <aside class="summary-panel" aria-label="Tóm tắt đơn hàng">
      <h2>Tóm tắt đơn hàng</h2>

      <dl class="summary-rows">
        <div class="row"><dt>Tạm tính</dt><dd id="subtotal">0&nbsp;₫</dd></div>
        <div class="row"><dt id="discountLabel">Giảm giá (-20%)</dt><dd id="discount" class="danger">-0&nbsp;₫</dd></div>
        <div class="row"><dt>Phí vận chuyển</dt><dd id="delivery">0&nbsp;₫</dd></div>
      </dl>

      <div class="divider"></div>

      <div class="total-row">
        <span>Tổng cộng</span>
        <strong id="total">0&nbsp;₫</strong>
      </div>

      <form class="promo-row" id="promoForm">
        <label class="sr-only" for="promoCode">Mã giảm giá</label>
        <input id="promoCode" type="text" placeholder="Nhập mã giảm giá" autocomplete="off">
        <button type="submit" class="apply-btn">Áp dụng</button>
      </form>

      <button class="checkout-btn" id="checkoutBtn" type="button">
        <span>Tiến hành thanh toán</span>
        <span class="arrow" aria-hidden="true">&#8594;</span>
      </button>
    </aside>
  </main>

  <template id="itemTemplate">
    <article class="cart-item">
      <div class="thumb-wrap">
        <img class="thumb" src="" alt="">
      </div>
      <div class="meta">
        <div class="meta-head">
          <h3 class="item-name"></h3>
          <button class="remove-btn" type="button" aria-label="Xóa sản phẩm">&#128465;</button>
        </div>
        <p class="sub">Kích cỡ: <span class="item-size"></span></p>
        <p class="sub">Màu: <span class="item-color"></span></p>
        <div class="meta-foot">
          <strong class="item-price"></strong>
          <div class="qty-control" role="group" aria-label="Điều chỉnh số lượng">
            <button class="qty-btn minus" type="button">-</button>
            <span class="qty-value">1</span>
            <button class="qty-btn plus" type="button">+</button>
          </div>
        </div>
      </div>
    </article>
  </template>

  <template id="catalogItemTemplate">
    <article class="catalog-item">
      <div class="catalog-thumb-wrap"><img class="catalog-thumb" src="" alt=""></div>
      <div class="catalog-meta">
        <h3 class="catalog-name"></h3>
        <p class="catalog-sub"></p>
        <strong class="catalog-price"></strong>
      </div>
      <button type="button" class="catalog-add-btn">Thêm vào giỏ</button>
    </article>
  </template>

  <script src="assets/js/cart.js"></script>
</body>
</html>
