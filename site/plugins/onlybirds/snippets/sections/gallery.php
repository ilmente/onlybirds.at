<?php
/**
 * Section 03: up to eight gallery plates with bird name and scientific name.
 * @var array $section
 */
$plates = $page->plates();
$n      = 0;
?>
<section id="<?= $section['anchor'] ?>" class="gallery">
  <?php snippet('section-head', ['number' => $section['number'], 'title' => $page->gallery_heading()->esc()]) ?>
  <div class="plate-grid">
    <?php foreach ($plates as $plate): ?>
    <figure class="plate-c">
      <span class="no"><?= esc(t('theme.gallery.plate')) ?> <?= str_pad((string)(++$n), 2, '0', STR_PAD_LEFT) ?></span>
      <div class="art"><?php snippet('image', ['file' => $plate, 'width' => 600, 'ratio' => 3 / 4, 'sizes' => '(max-width: 900px) 50vw, 25vw', 'alt' => $plate->bird()->or($plate->alt())->value()]) ?></div>
      <figcaption class="cap">
        <div class="cn"><?= $plate->bird()->esc() ?></div>
        <?php if ($plate->latin()->isNotEmpty()): ?>
        <div class="ln"><?= $plate->latin()->esc() ?></div>
        <?php endif ?>
      </figcaption>
    </figure>
    <?php endforeach ?>
  </div>
  <?php if ($page->gallery_note()->isNotEmpty()): ?>
  <p class="gallery-note"><?= $page->gallery_note()->esc() ?></p>
  <?php endif ?>
</section>
