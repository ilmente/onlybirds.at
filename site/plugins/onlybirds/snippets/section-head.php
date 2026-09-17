<?php
/**
 * Numbered section heading.
 * @var string|null $number  e.g. "01" (null for unnumbered sections)
 * @var string      $title   already escaped
 */
?>
<div class="sec-head">
  <?php if ($number): ?>
  <span class="sec-no"><?= $number ?></span>
  <?php endif ?>
  <h2><?= $title ?></h2>
  <span class="rule"></span>
</div>
