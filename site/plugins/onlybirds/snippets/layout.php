<?php
/**
 * Page frame: <head>, header, main content slot, footer, scripts.
 *
 * Usage in a template:
 *   <?php snippet('layout', slots: true) ?> … <?php endsnippet() ?>
 *
 * Icons: favicon, iOS/Android home screen icons and the web app manifest are served by the
 * theme at the site root (config/routes.php, files in assets/icons/). The share image is the
 * one picked on the Site page in the Panel, otherwise the theme's own.
 */

$theme    = $kirby->plugin('ilmente/onlybirds');
$language = $kirby->language();
$base     = $kirby->url();

$metaTitle = $page->meta_title()->isNotEmpty()
    ? $page->meta_title()->value()
    : ($page->isHomePage()
        ? trim($site->title() . ' — ' . $site->tagline(), ' —')
        : $page->title() . ' · ' . $site->title());

$metaDescription = $page->meta_description()->or($site->meta_description())->value();

// Open Graph wants "de_AT": taken from a language's locale, the bare code when none is set
$ogLocale = fn ($lang) => is_string($locale = $lang->locale(LC_ALL))
    ? strtok($locale, '.')
    : $lang->code();

// link preview image (WhatsApp, Facebook, X, …): the image picked on the Site page in the Panel,
// cropped to the 1200×630 every network accepts (the crop follows the image's focus point);
// the theme's own image with the logo when none is picked
if ($file = $site->share_image()->toFile()) {
    $image = $file->isResizable()
        ? $file->thumb(['width' => 1200, 'height' => 630, 'crop' => true, 'quality' => 80])
        : $file;
    $share = [
        'url'    => $image->url(),
        'width'  => $image->width(),
        'height' => $image->height(),
        'type'   => $image->mime(),
        'alt'    => $file->alt()->or($site->title())->value(),
    ];
} else {
    $share = [
        'url'    => $theme->asset('icons/share-image.png')->url(),
        'width'  => 1200,
        'height' => 630,
        'type'   => 'image/png',
        'alt'    => $site->title()->value(),
    ];
}
?>
<!DOCTYPE html>
<html lang="<?= $language->code() ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($metaTitle) ?></title>
<?php if ($metaDescription): ?>
<meta name="description" content="<?= esc($metaDescription) ?>">
<?php endif ?>
<link rel="canonical" href="<?= $page->url() ?>">
<?php foreach ($kirby->languages() as $lang): ?>
<link rel="alternate" hreflang="<?= $lang->code() ?>" href="<?= $page->url($lang->code()) ?>">
<?php endforeach ?>
<link rel="alternate" hreflang="x-default" href="<?= $page->url($kirby->defaultLanguage()->code()) ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= $site->title()->esc() ?>">
<meta property="og:title" content="<?= esc($metaTitle) ?>">
<?php if ($metaDescription): ?>
<meta property="og:description" content="<?= esc($metaDescription) ?>">
<?php endif ?>
<meta property="og:url" content="<?= $page->url() ?>">
<meta property="og:locale" content="<?= esc($ogLocale($language)) ?>">
<?php foreach ($kirby->languages()->not($language->code()) as $lang): ?>
<meta property="og:locale:alternate" content="<?= esc($ogLocale($lang)) ?>">
<?php endforeach ?>
<meta property="og:image" content="<?= $share['url'] ?>">
<meta property="og:image:type" content="<?= $share['type'] ?>">
<meta property="og:image:width" content="<?= $share['width'] ?>">
<meta property="og:image:height" content="<?= $share['height'] ?>">
<meta property="og:image:alt" content="<?= esc($share['alt']) ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= $base ?>/favicon.ico" sizes="16x16 32x32 48x48">
<link rel="icon" href="<?= $base ?>/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= $base ?>/apple-touch-icon.png">
<link rel="manifest" href="<?= $site->url() ?>/site.webmanifest">
<meta name="application-name" content="<?= $site->title()->esc() ?>">
<meta name="apple-mobile-web-app-title" content="<?= $site->title()->esc() ?>">
<meta name="theme-color" content="#EDE9DC">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400;1,9..144,500&family=Work+Sans:wght@400;500;600&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= $theme->asset('css/site.css')->url() ?>">
</head>
<body>

<?php snippet('header') ?>

<main id="top">
<?= $slot ?>
</main>

<?php snippet('footer') ?>

<script src="<?= $theme->asset('js/site.js')->url() ?>" defer></script>
</body>
</html>
