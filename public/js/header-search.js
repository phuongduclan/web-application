(function () {
  'use strict';

  var btn = document.getElementById('hdrSearchBtn');
  var form = document.getElementById('hdrSearchInline');
  var pill = document.getElementById('hdrButtonContainer');
  var input = document.getElementById('hdrSearchInput');
  var closeBtn = document.getElementById('hdrSearchClose');
  if (!btn || !form || !pill) return;

  function open() {
    pill.hidden = true;
    form.hidden = false;
    btn.setAttribute('aria-expanded', 'true');
    if (input) {
      setTimeout(function () { input.focus(); input.select(); }, 30);
    }
  }

  function close() {
    form.hidden = true;
    pill.hidden = false;
    btn.setAttribute('aria-expanded', 'false');
    btn.focus();
  }

  btn.addEventListener('click', function (e) {
    e.preventDefault();
    open();
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', function (e) {
      e.preventDefault();
      close();
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !form.hidden) close();
    if (e.key === '/' && form.hidden) {
      var tag = (document.activeElement && document.activeElement.tagName || '').toLowerCase();
      if (tag !== 'input' && tag !== 'textarea') {
        e.preventDefault();
        open();
      }
    }
  });
})();
