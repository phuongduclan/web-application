(function () {
  const cartItemsEl = document.getElementById("cartItems");
  const itemTemplate = document.getElementById("itemTemplate");
  const subtotalEl = document.getElementById("subtotal");
  const discountEl = document.getElementById("discount");
  const discountLabelEl = document.getElementById("discountLabel");
  const deliveryEl = document.getElementById("delivery");
  const totalEl = document.getElementById("total");
  const promoForm = document.getElementById("promoForm");
  const promoCode = document.getElementById("promoCode");
  const checkoutBtn = document.getElementById("checkoutBtn");
  const summaryPanel = document.querySelector(".summary-panel");
  const productCatalogEl = document.getElementById("productCatalog");
  const catalogItemTemplate = document.getElementById("catalogItemTemplate");

  /** Phí vận chuyển (VND) */
  const DELIVERY_FEE = 350000;
  let discountRate = 0.2;

  const cart = [
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

  const products = [
    {
      id: "p1",
      name: "Áo khoác bomber",
      size: "M",
      color: "Đen",
      price: 420000,
      image: "http://localhost:3845/assets/f04a017db094f9a20c2328f54a31b153619784f3.png"
    },
    {
      id: "p2",
      name: "Áo sơ mi denim",
      size: "L",
      color: "Xanh",
      price: 390000,
      image: "http://localhost:3845/assets/6193404e6d311ee399862065f2c6f6024e0d7c90.png"
    },
    {
      id: "p3",
      name: "Quần jogger basic",
      size: "L",
      color: "Xám",
      price: 310000,
      image: "http://localhost:3845/assets/bbf411c25fc84f87eeac1062fbe47f49c192d4f2.png"
    },
    {
      id: "p4",
      name: "Áo polo premium",
      size: "M",
      color: "Trắng",
      price: 270000,
      image: "http://localhost:3845/assets/f04a017db094f9a20c2328f54a31b153619784f3.png"
    },
    {
      id: "p5",
      name: "Quần tây slim fit",
      size: "L",
      color: "Đen",
      price: 340000,
      image: "http://localhost:3845/assets/bbf411c25fc84f87eeac1062fbe47f49c192d4f2.png"
    },
    {
      id: "p6",
      name: "Áo hoodie basic",
      size: "XL",
      color: "Kem",
      price: 360000,
      image: "http://localhost:3845/assets/6193404e6d311ee399862065f2c6f6024e0d7c90.png"
    },
    {
      id: "p7",
      name: "Áo thun thể thao",
      size: "S",
      color: "Xanh navy",
      price: 220000,
      image: "http://localhost:3845/assets/f04a017db094f9a20c2328f54a31b153619784f3.png"
    },
    {
      id: "p8",
      name: "Quần short casual",
      size: "M",
      color: "Be",
      price: 195000,
      image: "http://localhost:3845/assets/bbf411c25fc84f87eeac1062fbe47f49c192d4f2.png"
    }
  ];

  function money(value) {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
      maximumFractionDigits: 0
    }).format(Math.round(value));
  }

  function discountLabelText() {
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
    if (discountLabelEl) {
      discountLabelEl.textContent = discountLabelText();
    }
    if (deliveryEl) {
      deliveryEl.textContent = money(DELIVERY_FEE);
    }
    totalEl.textContent = money(total);

    if (animated) {
      summaryPanel.classList.remove("summary-pulse");
      void summaryPanel.offsetWidth;
      summaryPanel.classList.add("summary-pulse");
    }
  }

  function removeItem(id, node) {
    node.classList.add("fade-out");
    setTimeout(function () {
      const index = cart.findIndex(function (x) { return x.id === id; });
      if (index !== -1) {
        cart.splice(index, 1);
      }
      render();
      updateSummary(true);
    }, 220);
  }

  function changeQty(id, delta) {
    const item = cart.find(function (x) { return x.id === id; });
    if (!item) {
      return;
    }
    item.qty = Math.max(1, item.qty + delta);
    render();
    updateSummary(true);
  }

  function render() {
    cartItemsEl.innerHTML = "";
    cart.forEach(function (item) {
      const clone = itemTemplate.content.firstElementChild.cloneNode(true);
      clone.querySelector(".thumb").src = item.image;
      clone.querySelector(".thumb").alt = item.name;
      clone.querySelector(".item-name").textContent = item.name;
      clone.querySelector(".item-size").textContent = item.size;
      clone.querySelector(".item-color").textContent = item.color;
      clone.querySelector(".item-price").textContent = money(item.price * item.qty);
      clone.querySelector(".qty-value").textContent = String(item.qty);

      clone.querySelector(".remove-btn").addEventListener("click", function () {
        removeItem(item.id, clone);
      });
      clone.querySelector(".minus").addEventListener("click", function () {
        changeQty(item.id, -1);
      });
      clone.querySelector(".plus").addEventListener("click", function () {
        changeQty(item.id, 1);
      });

      cartItemsEl.appendChild(clone);
    });
  }

  function renderNewlyAdded(itemId) {
    render();
    var nodes = cartItemsEl.querySelectorAll(".cart-item");
    if (!nodes.length) {
      return;
    }
    var latest = nodes[nodes.length - 1];
    var item = cart.find(function (x) { return x.id === itemId; });
    if (!item || latest.querySelector(".item-name").textContent !== item.name) {
      return;
    }
    latest.classList.add("added");
  }

  function addProductToCart(product) {
    const existed = cart.find(function (item) {
      return (
        item.name === product.name &&
        item.size === product.size &&
        item.color === product.color
      );
    });

    if (existed) {
      existed.qty += 1;
      render();
      updateSummary(true);
      return;
    }

    const newItem = {
      id: Date.now(),
      name: product.name,
      size: product.size,
      color: product.color,
      price: product.price,
      qty: 1,
      image: product.image
    };
    cart.push(newItem);
    renderNewlyAdded(newItem.id);
    updateSummary(true);
  }

  function renderCatalog() {
    if (!productCatalogEl || !catalogItemTemplate) {
      return;
    }
    productCatalogEl.innerHTML = "";

    products.forEach(function (product) {
      const node = catalogItemTemplate.content.firstElementChild.cloneNode(true);
      node.querySelector(".catalog-thumb").src = product.image;
      node.querySelector(".catalog-thumb").alt = product.name;
      node.querySelector(".catalog-name").textContent = product.name;
      node.querySelector(".catalog-sub").textContent =
        "Kích cỡ " + product.size + " • " + product.color;
      node.querySelector(".catalog-price").textContent = money(product.price);
      node.querySelector(".catalog-add-btn").addEventListener("click", function () {
        addProductToCart(product);
      });
      productCatalogEl.appendChild(node);
    });
  }

  promoForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const code = promoCode.value.trim().toUpperCase();
    discountRate = code === "SAVE30" ? 0.3 : 0.2;
    promoForm.classList.remove("applied");
    void promoForm.offsetWidth;
    promoForm.classList.add("applied");
    updateSummary(true);
  });

  checkoutBtn.addEventListener("click", function () {
    checkoutBtn.classList.remove("checkout-pop");
    void checkoutBtn.offsetWidth;
    checkoutBtn.classList.add("checkout-pop");
    try {
      sessionStorage.setItem(
        "shopCoCheckout",
        JSON.stringify({ cart: cart, discountRate: discountRate })
      );
    } catch (e) {
      /* ignore */
    }
    setTimeout(function () {
      window.location.href = "checkout.html";
    }, 200);
  });

  render();
  renderCatalog();
  updateSummary(false);
})();
