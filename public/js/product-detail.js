(function () {
  var root = document.getElementById('pdRoot');
  if (!root) {
    return;
  }

  var dataNode = document.getElementById('pdVariants');
  if (!dataNode) {
    return;
  }

  var variants = [];
  try {
    variants = JSON.parse(dataNode.textContent || '[]');
  } catch (e) {
    variants = [];
  }

  if (!variants.length) {
    return;
  }

  var mainImg = root.querySelector('[data-pd-main]');
  var thumbsWrap = root.querySelector('[data-pd-thumbs]');
  var sizeWrap = root.querySelector('[data-pd-sizes]');
  var colorWrap = root.querySelector('[data-pd-colors]');
  var priceEl = root.querySelector('[data-pd-price]');
  var qtyInput = root.querySelector('[data-pd-qty]');
  var hidden = root.querySelector('[data-pd-variant-id]');
  var form = root.querySelector('[data-pd-form]');
  var cta = root.querySelector('[data-pd-cta]');
  var sizeLabel = root.querySelector('[data-pd-size-label]');
  var colorLabel = root.querySelector('[data-pd-color-label]');

  var state = { color: null, size: null };

  function formatPrice(n) {
    return (Number(n) || 0).toLocaleString('vi-VN') + ' đ';
  }

  function uniqColors() {
    var seen = {};
    var out = [];
    variants.forEach(function (v) {
      var c = v.color || '';
      if (c && !seen[c]) {
        seen[c] = true;
        out.push({ color: c, image: v.image });
      }
    });
    return out;
  }

  function uniqSizes() {
    var seen = {};
    var out = [];
    variants.forEach(function (v) {
      var s = v.size || '';
      if (s && !seen[s]) {
        seen[s] = true;
        out.push(s);
      }
    });
    return out;
  }

  function findVariant(color, size) {
    for (var i = 0; i < variants.length; i++) {
      if (variants[i].color === color && variants[i].size === size) {
        return variants[i];
      }
    }
    return null;
  }

  function variantsForColor(color) {
    return variants.filter(function (v) {
      return v.color === color;
    });
  }

  function imagesForColor(color) {
    var imgs = [];
    var seen = {};
    variantsForColor(color).forEach(function (v) {
      if (v.image && !seen[v.image]) {
        seen[v.image] = true;
        imgs.push(v.image);
      }
    });
    if (!imgs.length) {
      variants.forEach(function (v) {
        if (v.image && !seen[v.image]) {
          seen[v.image] = true;
          imgs.push(v.image);
        }
      });
    }
    return imgs;
  }

  function renderColors() {
    if (!colorWrap) {
      return;
    }
    var colors = uniqColors();
    colorWrap.innerHTML = '';
    colors.forEach(function (c) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'pd-swatch' + (c.color === state.color ? ' is-active' : '');
      btn.title = c.color;
      var sp = document.createElement('span');
      if (c.image) {
        sp.style.backgroundImage = "url('" + c.image.replace(/'/g, "%27") + "')";
      }
      btn.appendChild(sp);
      btn.addEventListener('click', function () {
        state.color = c.color;
        var sizes = variantsForColor(c.color).map(function (v) { return v.size; });
        if (sizes.indexOf(state.size) === -1) {
          state.size = sizes[0] || null;
        }
        renderAll();
      });
      colorWrap.appendChild(btn);
    });
  }

  function renderSizes() {
    if (!sizeWrap) {
      return;
    }
    var sizes = uniqSizes();
    var availSizes = state.color ? variantsForColor(state.color).map(function (v) { return v.size; }) : sizes;
    sizeWrap.innerHTML = '';
    sizes.forEach(function (s) {
      var btn = document.createElement('button');
      btn.type = 'button';
      var available = availSizes.indexOf(s) !== -1;
      btn.className = 'pd-pill' + (s === state.size ? ' is-active' : '') + (available ? '' : ' is-disabled');
      btn.textContent = s;
      btn.addEventListener('click', function () {
        if (!available) {
          return;
        }
        state.size = s;
        renderAll();
      });
      sizeWrap.appendChild(btn);
    });
  }

  function renderGallery() {
    if (!mainImg) {
      return;
    }
    var imgs = state.color ? imagesForColor(state.color) : imagesForColor(uniqColors()[0] && uniqColors()[0].color);
    if (!imgs.length && variants[0] && variants[0].image) {
      imgs = [variants[0].image];
    }
    if (imgs.length) {
      mainImg.src = imgs[0];
    }
    if (thumbsWrap) {
      thumbsWrap.innerHTML = '';
      imgs.forEach(function (src, idx) {
        var b = document.createElement('button');
        b.type = 'button';
        b.className = 'pd-thumb' + (idx === 0 ? ' is-active' : '');
        b.innerHTML = '<img src="' + src.replace(/"/g, '&quot;') + '" alt="">';
        b.addEventListener('click', function () {
          mainImg.src = src;
          thumbsWrap.querySelectorAll('.pd-thumb').forEach(function (el) {
            el.classList.remove('is-active');
          });
          b.classList.add('is-active');
        });
        thumbsWrap.appendChild(b);
      });
    }
  }

  function renderInfo() {
    var v = findVariant(state.color, state.size);
    if (priceEl) {
      priceEl.textContent = v ? formatPrice(v.price) : '—';
    }
    if (sizeLabel) {
      sizeLabel.textContent = state.size || '—';
    }
    if (colorLabel) {
      colorLabel.textContent = state.color || '—';
    }
    if (hidden) {
      hidden.value = v ? String(v.id) : '';
    }
    if (cta) {
      cta.disabled = !v;
      cta.textContent = v ? 'Thêm vào giỏ hàng' : 'Hết hàng / chưa chọn biến thể';
    }
  }

  function renderAll() {
    renderColors();
    renderSizes();
    renderGallery();
    renderInfo();
  }

  var firstColor = uniqColors()[0];
  state.color = firstColor ? firstColor.color : null;
  var firstSize = state.color ? (variantsForColor(state.color)[0] || {}).size : null;
  state.size = firstSize || (uniqSizes()[0] || null);

  renderAll();

  if (qtyInput) {
    var minus = root.querySelector('[data-pd-qty-minus]');
    var plus = root.querySelector('[data-pd-qty-plus]');
    if (minus) {
      minus.addEventListener('click', function () {
        var n = Math.max(1, (parseInt(qtyInput.value, 10) || 1) - 1);
        qtyInput.value = String(n);
      });
    }
    if (plus) {
      plus.addEventListener('click', function () {
        var n = Math.max(1, (parseInt(qtyInput.value, 10) || 1) + 1);
        qtyInput.value = String(n);
      });
    }
  }

  if (form) {
    form.addEventListener('submit', function (e) {
      if (!hidden.value) {
        e.preventDefault();
      }
    });
  }
})();
