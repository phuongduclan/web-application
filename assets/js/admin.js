(function () {
  'use strict';

  function scrollToThemSanPham() {
    var target = document.getElementById('them-san-pham');
    var input = document.getElementById('ten-sp-moi');
    if (!target) {
      return;
    }
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    if (input && typeof input.focus === 'function') {
      window.setTimeout(function () {
        input.focus();
      }, 350);
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    var nut = document.getElementById('nut-them-sp');
    if (nut) {
      nut.addEventListener('click', function (e) {
        var href = nut.getAttribute('href') || '';
        if (href.indexOf('#') === 0) {
          e.preventDefault();
          scrollToThemSanPham();
        }
      });
    }

    if (window.location.hash === '#them-san-pham') {
      window.setTimeout(scrollToThemSanPham, 100);
    }

    var oTimNd = document.getElementById('o-tim-nd');
    var bangNd = document.getElementById('bang-nguoi-dung');
    if (oTimNd && bangNd) {
      oTimNd.addEventListener('input', function () {
        var q = (oTimNd.value || '').toLowerCase().replace(/\s+/g, ' ').trim();
        var rows = bangNd.querySelectorAll('tbody tr.dong-nd');
        for (var i = 0; i < rows.length; i++) {
          var tr = rows[i];
          var hay = (tr.getAttribute('data-tim-kiem') || '').toLowerCase();
          tr.style.display = !q || hay.indexOf(q) !== -1 ? '' : 'none';
        }
      });
    }
  });

  /** Xác nhận trước khi gửi form xóa (thông báo tiếng Việt qua data-confirm). */
  document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!form || form.nodeName !== 'FORM' || !form.classList.contains('bieu-can-xac-nhan')) {
      return;
    }
    var msg = form.getAttribute('data-confirm');
    if (msg && !window.confirm(msg)) {
      e.preventDefault();
    }
  }, true);
})();
