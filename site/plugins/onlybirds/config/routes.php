<?php

/**
 * Root URLs served by the theme.
 *
 * Browsers, phones and crawlers look for favicon.ico and apple-touch-icon.png at the site
 * root, with or without <link> tags in the page, so the icon files keep their root URLs
 * while living in the theme (assets/icons/). The web app manifest behind "Add to Home
 * Screen" / "Install" is generated per language from the site title and description.
 */

use Kirby\Http\Response;

$icons   = dirname(__DIR__) . '/assets/icons';
$headers = ['Cache-Control' => 'public, max-age=604800'];
$routes  = [];

foreach ([
    'favicon.ico',
    'favicon.svg',
    'apple-touch-icon.png',
    'icon-192.png',
    'icon-512.png',
    'icon-192-maskable.png',
    'icon-512-maskable.png',
] as $file) {
    $routes[] = [
        'pattern' => $file,
        'method'  => 'GET|HEAD',
        'action'  => fn () => Response::file($icons . '/' . $file, ['headers' => $headers]),
    ];
}

// /site.webmanifest and /it/site.webmanifest: name, description and start URL of that language
$routes[] = [
    'pattern'  => 'site.webmanifest',
    'language' => '*',
    'method'   => 'GET|HEAD',
    'action'   => function ($language) use ($headers) {
        $kirby = kirby();
        $site  = $kirby->site();

        // icon-192.png / icon-512.png have rounded corners on a transparent ground;
        // the "maskable" ones are full-bleed squares that Android crops into its icon shape
        $icon = fn (int $size, string $purpose) => [
            'src'     => $kirby->url() . '/icon-' . $size . ($purpose === 'maskable' ? '-maskable' : '') . '.png',
            'sizes'   => $size . 'x' . $size,
            'type'    => 'image/png',
            'purpose' => $purpose,
        ];

        $manifest = [
            'name'       => $site->title()->value(),
            'short_name' => $site->title()->value(),
        ];

        if ($site->meta_description()->isNotEmpty()) {
            $manifest['description'] = $site->meta_description()->value();
        }

        $manifest += [
            'lang'             => $language->code(),
            'dir'              => $language->direction(),
            'start_url'        => $site->url(),
            'scope'            => $site->url() . '/',
            // a website, not an app: home screen shortcuts open it in the browser
            'display'          => 'browser',
            // paper, the site background (--paper in site.css)
            'background_color' => '#EDE9DC',
            'theme_color'      => '#EDE9DC',
            'icons'            => [
                $icon(192, 'any'),
                $icon(512, 'any'),
                $icon(192, 'maskable'),
                $icon(512, 'maskable'),
            ],
        ];

        return new Response(
            json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'application/manifest+json',
            200,
            $headers
        );
    },
];

return $routes;
