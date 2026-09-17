<?php
/**
 * Page frame: <head>, header, main content slot, footer, scripts.
 *
 * Usage in a template:
 *   <?php snippet('layout', slots: true) ?> … <?php endsnippet() ?>
 */

$theme    = $kirby->plugin('herd/onlybirds');
$language = $kirby->language();

$metaTitle = $page->meta_title()->isNotEmpty()
    ? $page->meta_title()->value()
    : ($page->isHomePage()
        ? trim($site->title() . ' — ' . $site->tagline(), ' —')
        : $page->title() . ' · ' . $site->title());

$metaDescription = $page->meta_description()->or($site->meta_description())->value();
$shareImage      = $site->share_image()->toFile();
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
<meta property="og:title" content="<?= esc($metaTitle) ?>">
<?php if ($metaDescription): ?>
<meta property="og:description" content="<?= esc($metaDescription) ?>">
<?php endif ?>
<meta property="og:url" content="<?= $page->url() ?>">
<meta property="og:locale" content="<?= $language->code() ?>">
<?php if ($shareImage): ?>
<meta property="og:image" content="<?= $shareImage->resize(1200)->url() ?>">
<?php endif ?>
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
