<?php

/**
 * Base configuration, tracked in git.
 * Host-specific settings (debug, cache, secrets) go into config.<host>.php
 * next to this file; those files are not tracked and are merged over this one by Kirby.
 */
return [
    // one page, several languages: content/home/home.<code>.txt, URLs / and /it (see site/languages)
    'languages'        => true,
    // never redirect by browser language – the default language (German) always answers on /
    'languages.detect' => false,

    'panel' => [
        // Panel UI language for new users; existing users keep their own setting
        'language' => 'en',
        // no Panel plugins with string templates in this theme, so the Vue
        // template compiler is not needed (smaller, safer Panel bundle)
        'vue' => [
            'compiler' => false,
        ],
        // the Panel tab shows the site's own icons; the theme serves them at the site root
        'favicon' => [
            ['rel' => 'apple-touch-icon', 'type' => 'image/png',     'href' => 'apple-touch-icon.png'],
            ['rel' => 'alternate icon',   'type' => 'image/x-icon',  'href' => 'favicon.ico'],
            ['rel' => 'shortcut icon',    'type' => 'image/svg+xml', 'href' => 'favicon.svg'],
        ],
    ],

    'debug' => false,
];
