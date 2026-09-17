<?php
$sections  = $page->visibleSections();
$primary   = isset($sections['excursions']) ? $page->hero_cta_primary() : null;
$secondary = $page->hero_cta_secondary();
?>
<div class="hero">
  <div class="sky" aria-hidden="true"><?php snippet('svg/sky') ?></div>
  <div class="wrap">
    <?php if ($page->hero_eyebrow()->isNotEmpty()): ?>
    <div class="eyebrow"><span><?= $page->hero_eyebrow()->esc() ?></span></div>
    <?php endif ?>
    <h1><?= $page->hero_title() ?></h1>
    <?php if ($page->hero_intro()->isNotEmpty()): ?>
    <div class="lede"><?= $page->hero_intro() ?></div>
    <?php endif ?>
    <?php if ($primary?->isNotEmpty() || $secondary->isNotEmpty()): ?>
    <div class="cta">
      <?php if ($primary?->isNotEmpty()): ?>
      <a class="btn solid" href="#<?= $sections['excursions']['anchor'] ?>"><?= $primary->esc() ?></a>
      <?php endif ?>
      <?php if ($secondary->isNotEmpty()): ?>
      <a class="btn ghost" href="#<?= $sections['contact']['anchor'] ?>"><?= $secondary->esc() ?></a>
      <?php endif ?>
    </div>
    <?php endif ?>
  </div>
</div>
