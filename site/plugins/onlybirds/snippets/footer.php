<?php

use Kirby\Toolkit\Str;

$copyright = Str::template($site->footer_copyright()->value(), ['year' => date('Y')]);
?>
<footer>
  <?php if ($copyright): ?>
  <span><?= esc($copyright) ?></span>
  <?php endif ?>
  <?php if ($site->footer_tagline()->isNotEmpty()): ?>
  <span><?= $site->footer_tagline()->esc() ?></span>
  <?php endif ?>
</footer>
