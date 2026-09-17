<?php
/**
 * Sticky header: brand, in-page navigation (home page only), language switch, mobile menu button.
 * The navigation is built from the same section list that renders the page.
 */
$home     = $site->homePage();
$sections = $page->is($home) ? $page->visibleSections() : [];
?>
<header class="nav">
  <a class="brand" href="<?= $home->url() ?>#top" aria-label="<?= $site->title()->esc() ?> — <?= esc(t('theme.nav.home')) ?>">
    <?php snippet('svg/logo') ?>
    <span>
      <span class="nm"><?= $site->title()->esc() ?></span>
      <?php if ($site->tagline()->isNotEmpty()): ?>
      <span class="sub"><?= $site->tagline()->esc() ?></span>
      <?php endif ?>
    </span>
  </a>

  <?php if ($sections !== []): ?>
  <nav class="links" id="links">
    <?php foreach ($sections as $section): ?>
    <a href="#<?= $section['anchor'] ?>"><?= esc($section['label']) ?></a>
    <?php endforeach ?>
  </nav>
  <?php endif ?>

  <div class="tools">
    <?php snippet('lang-switch') ?>
    <?php if ($sections !== []): ?>
    <button class="menu-btn" type="button" aria-label="<?= esc(t('theme.menu')) ?>" aria-controls="links" aria-expanded="false" data-menu-toggle>
      <svg viewBox="0 0 24 24" fill="none" stroke="#1E3A32" stroke-width="1.6" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
    <?php endif ?>
  </div>
</header>
