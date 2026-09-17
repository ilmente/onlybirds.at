<?php
/**
 * Bird silhouette from the theme library (config/birds.php).
 * @var string      $key      library key; unknown keys fall back to "glider"
 * @var string|null $fill     colour override
 * @var float|null  $opacity
 */
$birds = option('ilmente.onlybirds.birds');
$bird  = $birds[$key ?? ''] ?? $birds['glider'];
?>
<svg viewBox="0 0 100 100" aria-hidden="true"><path d="<?= $bird['path'] ?>" fill="<?= $fill ?? $bird['fill'] ?>"<?= isset($opacity) ? ' opacity="' . $opacity . '"' : '' ?>/></svg>
