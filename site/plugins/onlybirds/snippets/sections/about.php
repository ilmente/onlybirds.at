<?php
/**
 * Section 02: about text and portrait.
 * @var array $section
 */
$portrait = $page->portrait();
?>
<section id="<?= $section['anchor'] ?>">
  <?php snippet('section-head', ['number' => $section['number'], 'title' => $page->about_heading()->esc()]) ?>
  <div class="about">
    <div class="body">
      <?php if ($page->about_lead()->isNotEmpty()): ?>
      <p class="lead"><?= $page->about_lead()->kti() ?></p>
      <?php endif ?>
      <?= $page->about_text() ?>
    </div>
    <?php if ($portrait): ?>
    <figure class="portrait">
      <div class="ph"><?php snippet('image', ['file' => $portrait, 'width' => 680, 'ratio' => 4 / 5, 'sizes' => '(max-width: 900px) 100vw, 340px']) ?></div>
      <?php if ($page->about_caption()->isNotEmpty()): ?>
      <figcaption><?= $page->about_caption()->esc() ?></figcaption>
      <?php endif ?>
    </figure>
    <?php endif ?>
  </div>
</section>
