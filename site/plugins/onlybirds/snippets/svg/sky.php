<?php
/**
 * Decorative hero background: dawn gradient, sun, hills and a flock.
 */
$flock = 'M0 8 C8 0 18-2 28 4 C31 1 33 1 36 4 C46-2 56 0 64 8 C54 5 46 6 38 10 L34 16 L30 10 C22 6 12 5 0 8 Z';
$birds = [
    ['translate(300 170) scale(1.35)',            0.7],
    ['translate(430 120) scale(1.05) rotate(-6)', 0.62],
    ['translate(255 255) scale(0.85) rotate(4)',  0.55],
    ['translate(545 205) scale(0.7) rotate(-3)',  0.45],
    ['translate(620 150) scale(0.5)',             0.35],
];
?>
<svg width="100%" height="100%" viewBox="0 0 1440 820" preserveAspectRatio="xMidYMax slice" aria-hidden="true">
  <defs>
    <linearGradient id="dawn" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0%" stop-color="#E9E4D4"/><stop offset="52%" stop-color="#E7E1CE"/><stop offset="100%" stop-color="#D9D3BE"/>
    </linearGradient>
  </defs>
  <rect width="1440" height="820" fill="url(#dawn)"/>
  <circle cx="1090" cy="200" r="72" fill="#C08A2D" opacity="0.22"/>
  <path d="M0 640 Q360 560 720 610 T1440 590 V820 H0 Z" fill="#CFC8B0" opacity="0.9"/>
  <path d="M0 700 Q400 640 820 690 T1440 670 V820 H0 Z" fill="#BEB79C" opacity="0.85"/>
  <path d="M0 760 Q480 720 900 758 T1440 748 V820 H0 Z" fill="#2E6E8E" opacity="0.14"/>
  <g fill="#1E3A32">
    <?php foreach ($birds as [$transform, $opacity]): ?>
    <path d="<?= $flock ?>" transform="<?= $transform ?>" opacity="<?= $opacity ?>"/>
    <?php endforeach ?>
  </g>
</svg>
