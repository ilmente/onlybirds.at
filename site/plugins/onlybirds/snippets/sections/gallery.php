<?php
/**
 * Section 03: up to eight gallery plates with bird name and scientific name.
 * Each plate links to its full-size image; site.js turns those links into a lightbox.
 * @var array $section
 */
$plates = $page->plates();
?>
<section id="<?= $section['anchor'] ?>" class="gallery">
  <?php snippet('section-head', ['number' => $section['number'], 'title' => $page->gallery_heading()->esc()]) ?>
  <div class="plate-grid" data-lightbox-close="<?= esc(t('theme.gallery.close')) ?>" data-lightbox-prev="<?= esc(t('theme.gallery.prev')) ?>" data-lightbox-next="<?= esc(t('theme.gallery.next')) ?>">
    <?php foreach ($plates as $plate): ?>
    <?php $full = $plate->isResizable() ? $plate->resize(1600)->url() : $plate->url() ?>
    <figure class="plate-c">
      <a class="art" href="<?= $full ?>" data-lightbox data-title="<?= $plate->bird()->esc() ?>" data-subtitle="<?= $plate->latin()->esc() ?>">
        <?php snippet('image', ['file' => $plate, 'width' => 600, 'ratio' => 3 / 4, 'sizes' => '(max-width: 900px) 50vw, 25vw', 'alt' => $plate->bird()->or($plate->alt())->value()]) ?>
      </a>
      <figcaption class="cap">
        <span class="cn"><?= $plate->bird()->esc() ?></span>
        <?php if ($plate->latin()->isNotEmpty()): ?>
        <span class="ln"><?= $plate->latin()->esc() ?></span>
        <?php endif ?>
      </figcaption>
    </figure>
    <?php endforeach ?>
  </div>
  <?php if ($page->gallery_note()->isNotEmpty()): ?>
  <p class="gallery-note"><?= $page->gallery_note()->esc() ?></p>
  <?php endif ?>
</section>
