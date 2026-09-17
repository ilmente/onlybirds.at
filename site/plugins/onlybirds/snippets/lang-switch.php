<?php
/**
 * Language switch: one link per configured language, pointing to the same page.
 * Adding a language in site/languages automatically adds a button here.
 */
if ($kirby->languages()->count() < 2) {
    return;
}
?>
<nav class="lang" aria-label="<?= esc(t('theme.language')) ?>">
  <?php foreach ($kirby->languages() as $lang): ?>
  <?php $isCurrent = $lang->code() === $kirby->language()->code() ?>
  <a href="<?= $page->url($lang->code()) ?>" hreflang="<?= $lang->code() ?>" lang="<?= $lang->code() ?>"<?= $isCurrent ? ' class="on" aria-current="page"' : '' ?>><?= strtoupper($lang->code()) ?></a>
  <?php endforeach ?>
</nav>
