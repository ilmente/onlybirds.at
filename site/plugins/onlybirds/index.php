<?php

/**
 * onlybirds theme
 *
 * Everything the front end and the Panel need lives in this folder:
 * blueprints, templates, snippets, page models, UI translations, routes and assets
 * (assets/ is served automatically by Kirby under /media/plugins/ilmente/onlybirds/;
 * the icons in assets/icons/ are additionally served at the site root, see config/routes.php).
 *
 * Site-specific configuration stays outside the theme on purpose:
 *   site/config/config.php   – languages, caching, debug
 *   site/languages/*.php     – the languages the site is published in
 *   content/                 – editorial content, never part of a deploy
 */

use Kirby\Cms\App as Kirby;
use Kirby\Filesystem\Dir;
use Kirby\Filesystem\F;

load([
    'HomePage' => __DIR__ . '/models/HomePage.php',
    'TourPage' => __DIR__ . '/models/TourPage.php',
]);

/**
 * Registers every file of one type below a folder, keyed by its relative
 * path without extension: snippets/sections/hero.php => "sections/hero".
 * Adding a blueprint, template or snippet is therefore just adding a file.
 */
$collect = function (string $dir, string $extension): array {
    $files = [];

    foreach (Dir::index($dir, true) as $path) {
        if (is_file($dir . '/' . $path) === true && F::extension($path) === $extension) {
            $files[substr($path, 0, -(strlen($extension) + 1))] = $dir . '/' . $path;
        }
    }

    return $files;
};

$translations = [];

foreach (glob(__DIR__ . '/translations/*.php') as $file) {
    $translations[F::name($file)] = require $file;
}

// Kirby falls back to "en" for missing keys; until an English file exists,
// use the German strings there so t() never returns null in a new language.
$translations['en'] ??= $translations['de'];

Kirby::plugin('ilmente/onlybirds', [
    'blueprints'   => $collect(__DIR__ . '/blueprints', 'yml'),
    'templates'    => $collect(__DIR__ . '/templates', 'php'),
    'snippets'     => $collect(__DIR__ . '/snippets', 'php'),
    'pageModels'   => [
        'home' => 'HomePage',
        'tour' => 'TourPage',
    ],
    'translations' => $translations,
    'options'      => [
        // bird silhouettes used by tour cards; single source of truth for the SVG paths
        'birds' => require __DIR__ . '/config/birds.php',
    ],
    // /favicon.ico, /apple-touch-icon.png, /icon-*.png and /site.webmanifest, from assets/icons/
    'routes'       => require __DIR__ . '/config/routes.php',
    'hooks' => [
        /**
         * Keeps the pages cache in sync with deployments: Kirby flushes it on content
         * changes, but not when theme files change. The newest modification time of this
         * folder is stored in the cache itself; when a pull changes any theme file, the
         * next request flushes the cache once and stores the new stamp.
         */
        'route:before' => function () {
            $cache = $this->cache('pages');

            if (($cache->options()['active'] ?? false) !== true) {
                return;
            }

            $stamp = (string)Dir::modified(__DIR__);

            if ($cache->get('ilmente-onlybirds-stamp') !== $stamp) {
                $cache->flush();
                $cache->set('ilmente-onlybirds-stamp', $stamp);
            }
        },
    ],
]);
