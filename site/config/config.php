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
    ],

    'debug' => false,
];
