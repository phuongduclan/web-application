(function () {
  const DELIVERY_FEE = 350000;

  const defaultCart = [
    {
      id: 1,
      name: "Áo thun họa tiết gradient",
      size: "L",
      color: "Trắng",
      price: 360000,
      qty: 1,
      image: "http://localhost:3845/assets/f04a017db094f9a20c2328f54a31b153619784f3.png"
    },
    {
      id: 2,
      name: "Áo sơ mi caro",
      size: "M",
      color: "Đỏ",
      price: 450000,
      qty: 1,
      image: "http://localhost:3845/assets/6193404e6d311ee399862065f2c6f6024e0d7c90.png"
    },
    {
      id: 3,
      name: "Quần jean skinny",
      size: "L",
      color: "Xanh dương",
      price: 600000,
      qty: 1,
      image: "http://localhost:3845/assets/bbf411c25fc84f87eeac1062fbe47f49c192d4f2.png"
    }
  ];

  let cart = defaultCart.slice();
  let discountRate = 0.2;

  try {
    const raw = sessionStorage.getItem("shopCoCheckout");
    if (raw) {
      const data = JSON.parse(raw);
      if (Array.isArray(data.cart) && data.cart.length) {
        cart = data.cart;
      }
      if (typeof data.discountRate === "number") {
        discountRate = data.discountRate;
      }
    }
  } catch (e) {
    cart = defaultCart.slice();
  }

  const subtotalEl = document.getElementById("subtotal");
  const discountEl = document.getElementById("discount");
  const discountRow = discountEl ? discountEl.closest(".row") : null;
  const totalEl = document.getElementById("total");
  const deliveryEl = document.getElementById("delivery");
  const checkoutItemsEl = document.getElementById("checkoutItems");
  const template = document.getElementById("checkoutItemTemplate");
  const form = document.getElementById("checkoutForm");
  const placeOrderBtn = document.getElementById("placeOrderBtn");
  const summaryPanel = document.querySelector(".checkout-summary");
  const cardFields = document.getElementById("cardFields");
  const payRadios = document.querySelectorAll('input[name="payMethod"]');

  function money(value) {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
      maximumFractionDigits: 0
    }).format(Math.round(value));
  }

  function discountLabel() {
    const pct = Math.round(discountRate * 100);
    return "Giảm giá (-" + pct + "%)";
  }

  function updateSummary(animated) {
    const subtotal = cart.reduce(function (sum, item) {
      return sum + item.price * item.qty;
    }, 0);
    const discount = subtotal * discountRate;
    const total = subtotal - discount + DELIVERY_FEE;

    subtotalEl.textContent = money(subtotal);
    discountEl.textContent = money(-discount);
    totalEl.textContent = money(total);
    if (deliveryEl) {
      deliveryEl.textContent = money(DELIVERY_FEE);
    }

    if (discountRow && discountRow.querySelector("dt")) {
      discountRow.querySelector("dt").textContent = discountLabel();
    }

    if (animated && summaryPanel) {
      summaryPanel.classList.remove("summary-pulse");
      void summaryPanel.offsetWidth;
      summaryPanel.classList.add("summary-pulse");
    }
  }

  function renderItems() {
    checkoutItemsEl.innerHTML = "";
    cart.forEach(function (item) {
      const node = template.content.firstElementChild.cloneNode(true);
      const thumb = node.querySelector(".checkout-line-thumb");
      thumb.style.backgroundImage = "url(\"" + item.image + "\")";
      node.querySelector(".checkout-line-name").textContent = item.name;
      node.querySelector(".checkout-line-detail").textContent =
        "SL " + item.qty + " · " + item.size + " · " + item.color;
      node.querySelector(".checkout-line-price").textContent = money(item.price * item.qty);
      checkoutItemsEl.appendChild(node);
    });
  }

  function setCardFieldsVisible(show) {
    if (!cardFields) {
      return;
    }
    cardFields.classList.toggle("hidden", !show);
    const inputs = cardFields.querySelectorAll("input");
    inputs.forEach(function (el) {
      el.required = show;
      if (!show) {
        el.setCustomValidity("");
      }
    });
  }

  payRadios.forEach(function (radio) {
    radio.addEventListener("change", function () {
      setCardFieldsVisible(radio.value === "card");
    });
  });

  setCardFieldsVisible(true);

  function markInvalid(el, invalid) {
    if (!el) {
      return;
    }
    el.classList.toggle("field-error", invalid);
  }

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    const required = form.querySelectorAll("[required]");
    let ok = true;
    required.forEach(function (el) {
      const field = el.closest(".field");
      const valid = el.type === "radio" ? true : el.checkValidity();
      if (!valid) {
        ok = false;
      }
      markInvalid(field, el.type !== "radio" && !el.checkValidity());
    });

    if (document.querySelector('input[name="payMethod"]:checked') && document.querySelector('input[name="payMethod"]:checked').value === "card") {
      const num = document.getElementById("cardNumber");
      const exp = document.getElementById("cardExpiry");
      const cvc = document.getElementById("cardCvc");
      if (num && num.value.replace(/\s/g, "").length < 13) {
        markInvalid(num.closest(".field"), true);
        ok = false;
      }
      if (exp && exp.value.trim().length < 4) {
        markInvalid(exp.closest(".field"), true);
        ok = false;
      }
      if (cvc && cvc.value.trim().length < 3) {
        markInvalid(cvc.closest(".field"), true);
        ok = false;
      }
    }

    if (!ok) {
      var firstBad = form.querySelector(".field-error input, .field-error select");
      if (firstBad) {
        firstBad.focus();
      }
      return;
    }

    placeOrderBtn.classList.remove("success-pulse");
    void placeOrderBtn.offsetWidth;
    placeOrderBtn.classList.add("success-pulse");
    placeOrderBtn.disabled = true;

    setTimeout(function () {
      alert("Đặt hàng thành công (bản demo). Kết nối backend hoặc cổng thanh toán tại đây.");
      placeOrderBtn.disabled = false;
    }, 400);
  });

  form.querySelectorAll("input, select").forEach(function (el) {
    el.addEventListener("input", function () {
      const field = el.closest(".field");
      markInvalid(field, false);
    });
  });

  renderItems();
  updateSummary(false);
})();
