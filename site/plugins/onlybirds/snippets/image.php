<?php
/**
 * Responsive <img> for a Kirby file. Bitmaps get resized/cropped variants and a srcset;
 * SVGs are embedded as they are.
 *
 * @var \Kirby\Cms\File $file
 * @var int             $width   largest rendered width in px (default 1200)
 * @var float|null      $ratio   width/height crop ratio; null keeps the proportions
 * @var string          $sizes   sizes attribute (default 100vw)
 * @var string|null     $alt     alt text override (default: the file's alt field)
 * @var bool            $lazy    lazy-load (default true; false for above-the-fold images)
 */
$width ??= 1200;
$ratio ??= null;
$sizes ??= '100vw';
$alt   ??= $file->alt()->value();
$lazy  ??= true;

if ($file->isResizable() === true) {
    $height = $ratio ? (int)round($width / $ratio) : null;
    $image  = $ratio ? $file->crop($width, $height) : $file->resize($width);
    $set    = [];

    foreach ([0.35, 0.7, 1] as $factor) {
        $w = (int)round($width * $factor);
        $set[$w . 'w'] = $ratio
            ? ['width' => $w, 'height' => (int)round($w / $ratio), 'crop' => true]
            : ['width' => $w];
    }

    $srcset = $file->srcset($set);
} else {
    $image  = $file;
    $srcset = null;
}
?>
<img src="<?= $image->url() ?>"<?= $srcset ? ' srcset="' . $srcset . '" sizes="' . esc($sizes) . '"' : '' ?> width="<?= $image->width() ?>" height="<?= $image->height() ?>" alt="<?= esc($alt) ?>"<?= $lazy ? ' loading="lazy" decoding="async"' : ' fetchpriority="high"' ?>>
