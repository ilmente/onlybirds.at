<?php
/**
 * Decorative hero background in three layers, so nothing is cropped on wide screens:
 * the dawn gradient is the .sky background (CSS), the sun and the flock are pinned
 * to fixed positions of the hero box, and only the hills stretch along the bottom.
 */
$flock = 'M0 8 C8 0 18-2 28 4 C31 1 33 1 36 4 C46-2 56 0 64 8 C54 5 46 6 38 10 L34 16 L30 10 C22 6 12 5 0 8 Z';
$birds = [
    ['translate(50 60) scale(1.35)',            0.7],
    ['translate(180 10) scale(1.05) rotate(-6)', 0.62],
    ['translate(5 145) scale(0.85) rotate(4)',   0.55],
    ['translate(295 95) scale(0.7) rotate(-3)',  0.45],
    ['translate(370 40) scale(0.5)',             0.35],
];
?>
<span class="sun"></span>
<svg class="flock" viewBox="0 0 440 180" aria-hidden="true">
  <g fill="#1E3A32">
    <?php foreach ($birds as [$transform, $opacity]): ?>
    <path d="<?= $flock ?>" transform="<?= $transform ?>" opacity="<?= $opacity ?>"/>
    <?php endforeach ?>
  </g>
</svg>
<svg class="hills" viewBox="0 540 1440 280" preserveAspectRatio="none" aria-hidden="true">
  <path d="M0 640 Q360 560 720 610 T1440 590 V820 H0 Z" fill="#CFC8B0" opacity="0.9"/>
  <path d="M0 700 Q400 640 820 690 T1440 670 V820 H0 Z" fill="#BEB79C" opacity="0.85"/>
  <path d="M0 760 Q480 720 900 758 T1440 748 V820 H0 Z" fill="#2E6E8E" opacity="0.14"/>
</svg>
