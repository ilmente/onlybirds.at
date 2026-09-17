<?php
/**
 * Section 01: the featured tour (large card) and the other published tours (cards).
 * @var array $section  anchor / number / label from HomePage::visibleSections()
 */
$featured = $page->featuredTour();
$cards    = $page->tourCards();
?>
<section id="<?= $section['anchor'] ?>" class="course">
  <?php snippet('section-head', ['number' => $section['number'], 'title' => $page->excursions_heading()->esc()]) ?>

  <?php if ($featured): ?>
  <?php $poster = $featured->poster(); $pdf = $featured->pdf(); ?>
  <div class="feature<?= $poster ? '' : ' no-poster' ?>">
    <?php if ($poster): ?>
    <?php $posterImage = ['file' => $poster, 'width' => 840, 'ratio' => 419 / 595, 'sizes' => '(max-width: 900px) 100vw, 40vw', 'lazy' => false] ?>
    <?php if ($pdf): ?>
    <a class="locandina img" href="<?= $pdf->url() ?>" target="_blank" rel="noopener" aria-label="<?= esc(tt('theme.excursion.poster_aria', null, ['title' => $featured->title()->value()])) ?>">
      <?php snippet('image', $posterImage) ?>
    </a>
    <?php else: ?>
    <div class="locandina img">
      <?php snippet('image', $posterImage) ?>
    </div>
    <?php endif ?>
    <?php endif ?>

    <div class="info">
      <?php if ($featured->kicker()->isNotEmpty()): ?>
      <div class="kicker"><?= $featured->kicker()->esc() ?></div>
      <?php endif ?>
      <h3><?= $featured->title()->esc() ?></h3>
      <?php if ($dates = $featured->dates()): ?>
      <div class="when"><?= $dates ?></div>
      <?php endif ?>
      <?php if ($featured->text()->isNotEmpty()): ?>
      <p><?= $featured->text()->kti() ?></p>
      <?php endif ?>
      <?php if ($featured->highlights()->isNotEmpty()): ?>
      <ul>
        <?php foreach ($featured->highlights() as $i => $highlight): ?>
        <li><span class="ic"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span><span><?= $highlight->text()->esc() ?></span></li>
        <?php endforeach ?>
      </ul>
      <?php endif ?>
      <div class="actions">
        <?php if ($pdf): ?>
        <a class="btn gold" href="<?= $pdf->url() ?>" target="_blank" rel="noopener"><?= esc(t('theme.excursion.open_pdf')) ?></a>
        <?php endif ?>
        <?php if ($featured->link()->isNotEmpty()): ?>
        <a class="btn ghost inverse" href="<?= $featured->link()->esc() ?>" target="_blank" rel="noopener"><?= esc($featured->linkHost()) ?></a>
        <?php endif ?>
        <a class="btn ghost inverse" href="#contact"><?= esc(t('theme.excursion.questions')) ?></a>
      </div>
      <?php if ($featured->partner_name()->isNotEmpty()): ?>
      <div class="coop">
        <?= esc(t('theme.excursion.partner')) ?> <?= $featured->partner_name()->esc() ?>
        <?php if ($featured->partner_url()->isNotEmpty()): ?>
        · <a href="<?= $featured->partner_url()->esc() ?>" target="_blank" rel="noopener"><?= esc(preg_replace('/^www\./', '', parse_url($featured->partner_url()->value(), PHP_URL_HOST) ?? '')) ?></a>
        <?php endif ?>
      </div>
      <?php endif ?>
    </div>
  </div>
  <?php endif ?>

  <?php if ($cards->isNotEmpty()): ?>
  <div class="trip-head"><?= esc(t('theme.tours.heading')) ?></div>
  <div class="poster-row">
    <?php foreach ($cards as $tour): ?>
    <?php $thumb = $tour->poster(); $pdf = $tour->pdf(); ?>
    <article class="poster">
      <div class="head">
        <?php if ($thumb): ?>
        <?php if ($pdf): ?><a class="thumb" href="<?= $pdf->url() ?>" target="_blank" rel="noopener" tabindex="-1" aria-hidden="true"><?php else: ?><div class="thumb"><?php endif ?>
          <?php snippet('image', ['file' => $thumb, 'width' => 128, 'ratio' => 1, 'sizes' => '64px', 'alt' => '']) ?>
        <?php if ($pdf): ?></a><?php else: ?></div><?php endif ?>
        <?php endif ?>
        <div>
          <?php if ($tour->tag()->isNotEmpty()): ?>
          <div class="tag"><?= $tour->tag()->esc() ?></div>
          <?php endif ?>
          <h4><?= $tour->title()->esc() ?></h4>
          <?php if ($dates = $tour->dates()): ?>
          <div class="season"><?= $dates ?></div>
          <?php endif ?>
        </div>
      </div>
      <?php if ($tour->text()->isNotEmpty()): ?>
      <p><?= $tour->text()->kti() ?></p>
      <?php endif ?>
      <?php if ($pdf || $tour->link()->isNotEmpty()): ?>
      <div class="links">
        <?php if ($pdf): ?>
        <a class="more" href="<?= $pdf->url() ?>" target="_blank" rel="noopener"><?= esc(t('theme.tours.pdf')) ?> &rarr;</a>
        <?php endif ?>
        <?php if ($tour->link()->isNotEmpty()): ?>
        <a class="more" href="<?= $tour->link()->esc() ?>" target="_blank" rel="noopener"><?= esc($tour->linkHost()) ?> &rarr;</a>
        <?php endif ?>
      </div>
      <?php endif ?>
      <div class="bird" aria-hidden="true"><?php snippet('svg/bird', ['key' => $tour->icon()->value(), 'fill' => '#EDE9DC']) ?></div>
    </article>
    <?php endforeach ?>
  </div>
  <?php endif ?>
</section>
