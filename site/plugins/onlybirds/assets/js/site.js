/* Mobile navigation toggle. Language switching and the gallery are server-rendered. */
(function () {
  var toggle = document.querySelector('[data-menu-toggle]');
  var links = document.getElementById('links');

  if (!toggle || !links) {
    return;
  }

  function setOpen(open) {
    links.classList.toggle('open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  toggle.addEventListener('click', function () {
    setOpen(!links.classList.contains('open'));
  });

  links.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      setOpen(false);
    });
  });
})();

/* Gallery lightbox: plates link to their full-size image; this turns the links into an
   overlay with caption, close, previous/next, keyboard support and fade in/out. */
(function () {
  var links = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
  var grid = document.querySelector('.plate-grid');

  if (!links.length || !grid) {
    return;
  }

  var labels = {
    close: grid.getAttribute('data-lightbox-close') || 'Close',
    prev: grid.getAttribute('data-lightbox-prev') || 'Previous',
    next: grid.getAttribute('data-lightbox-next') || 'Next'
  };

  var box = document.createElement('div');
  box.className = 'lightbox';
  box.hidden = true;
  box.setAttribute('role', 'dialog');
  box.setAttribute('aria-modal', 'true');
  box.innerHTML =
    '<div class="lightbox-backdrop"></div>' +
    '<figure class="lightbox-figure"><img alt=""><figcaption><span class="cn"></span><span class="ln"></span></figcaption></figure>' +
    '<button type="button" class="lightbox-close" aria-label="' + labels.close + '">&times;</button>' +
    '<button type="button" class="lightbox-prev" aria-label="' + labels.prev + '">&lsaquo;</button>' +
    '<button type="button" class="lightbox-next" aria-label="' + labels.next + '">&rsaquo;</button>';
  document.body.appendChild(box);

  var img = box.querySelector('img');
  var title = box.querySelector('.cn');
  var subtitle = box.querySelector('.ln');
  var current = -1;
  var lastFocus = null;
  var hideTimer = null;

  function show(index) {
    current = (index + links.length) % links.length;
    var link = links[current];
    img.src = link.getAttribute('href');
    img.alt = link.getAttribute('data-title') || '';
    title.textContent = link.getAttribute('data-title') || '';
    subtitle.textContent = link.getAttribute('data-subtitle') || '';
    subtitle.hidden = !subtitle.textContent;
  }

  function open(index) {
    clearTimeout(hideTimer);
    lastFocus = document.activeElement;
    show(index);
    box.hidden = false;
    document.body.classList.add('lightbox-open');
    // force a reflow between un-hiding and adding the class, so the opacity transition runs
    void box.offsetWidth;
    box.classList.add('is-open');
    box.querySelector('.lightbox-close').focus();
    box.querySelectorAll('.lightbox-prev, .lightbox-next').forEach(function (button) {
      button.hidden = links.length < 2;
    });
  }

  function close() {
    if (box.hidden) {
      return;
    }
    box.classList.remove('is-open');
    document.body.classList.remove('lightbox-open');
    hideTimer = setTimeout(function () {
      box.hidden = true;
      img.removeAttribute('src');
      if (lastFocus && lastFocus.focus) {
        lastFocus.focus();
      }
    }, 380);
  }

  links.forEach(function (link, index) {
    link.addEventListener('click', function (event) {
      event.preventDefault();
      open(index);
    });
  });

  box.querySelector('.lightbox-backdrop').addEventListener('click', close);
  img.addEventListener('click', close);
  box.querySelector('.lightbox-close').addEventListener('click', close);
  box.querySelector('.lightbox-prev').addEventListener('click', function () { show(current - 1); });
  box.querySelector('.lightbox-next').addEventListener('click', function () { show(current + 1); });

  document.addEventListener('keydown', function (event) {
    if (box.hidden) {
      return;
    }
    if (event.key === 'Escape') {
      close();
    } else if (event.key === 'ArrowLeft') {
      show(current - 1);
    } else if (event.key === 'ArrowRight') {
      show(current + 1);
    }
  });
})();
