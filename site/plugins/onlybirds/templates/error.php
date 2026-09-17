<?php snippet('layout', slots: true) ?>

<section class="error">
  <?php snippet('section-head', ['number' => null, 'title' => $page->title()->esc()]) ?>
  <?= $page->text()->kt() ?>
  <a class="btn solid" href="<?= $site->url() ?>"><?= t('theme.nav.home') ?></a>
</section>

<?php endsnippet() ?>
