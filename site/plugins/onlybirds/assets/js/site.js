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
