<?php
/**
 * Footer: copyright on the left (plain text, {{ year }} replaced by the current year),
 * credits on the right (writer field with links only, stored as sanitised HTML).
 */

use Kirby\Toolkit\Str;

$copyright = Str::template((string)$site->footer_copyright()->value(), ['year' => date('Y')]);

// Space Mono draws © tiny; the symbol gets its own span so the CSS can enlarge it
$copyright = str_replace('©', '<span class="c">©</span>', esc($copyright));
?>
<footer>
  <?php if ($copyright): ?>
  <p class="copyright"><?= $copyright ?></p>
  <?php endif ?>
  <?php if ($site->footer_credits()->isNotEmpty()): ?>
  <p class="credits"><?= $site->footer_credits() ?></p>
  <?php endif ?>
</footer>
