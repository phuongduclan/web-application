function formatCurrency(value) {
  return `$${value.toFixed(2)}`;
}

function updateCartSummary() {
  const cartItems = document.querySelectorAll(".cart-item");
  const subtotalEl = document.getElementById("cartSubtotal");
  const totalEl = document.getElementById("cartTotal");
  const shippingEl = document.getElementById("cartShipping");
  const discountEl = document.getElementById("cartDiscount");

  if (!cartItems.length || !subtotalEl || !totalEl) {
    return;
  }

  let subtotal = 0;
  const shipping = 12;
  const discount = 0;

  cartItems.forEach((item) => {
    const qtyEl = item.querySelector(".qty-value");
    const priceEl = item.querySelector(".cart-item-price");
    const quantity = Number(qtyEl?.textContent || 1);
    const unitPrice = Number(item.dataset.price || 0);
    const linePrice = quantity * unitPrice;

    subtotal += linePrice;

    if (priceEl) {
      priceEl.textContent = formatCurrency(linePrice);
    }
  });

  subtotalEl.textContent = formatCurrency(subtotal);
  totalEl.textContent = formatCurrency(subtotal + shipping - discount);

  if (shippingEl) {
    shippingEl.textContent = formatCurrency(shipping);
  }

  if (discountEl) {
    discountEl.textContent = formatCurrency(discount);
  }
}

document.querySelectorAll(".qty-btn").forEach((button) => {
  button.addEventListener("click", function () {
    const item = this.closest(".cart-item");
    const qtyEl = item?.querySelector(".qty-value");

    if (!qtyEl) {
      return;
    }

    const currentValue = Number(qtyEl.textContent || 1);
    const nextValue =
      this.dataset.action === "plus"
        ? currentValue + 1
        : Math.max(1, currentValue - 1);

    qtyEl.textContent = String(nextValue);
    updateCartSummary();
  });
});

document.querySelectorAll(".cart-item .text-btn").forEach((button) => {
  button.addEventListener("click", function () {
    const item = this.closest(".cart-item");

    if (item) {
      item.remove();
      updateCartSummary();
    }
  });
});

const checkoutForm = document.getElementById("checkoutForm");

if (checkoutForm) {
  checkoutForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const message = document.getElementById("checkoutMessage");

    if (message) {
      message.textContent =
        "Your order has been placed successfully. A confirmation email will be sent shortly.";
    }
  });
}

updateCartSummary();
