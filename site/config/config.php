<?php

/**
 * Base configuration for every environment.
 * Host-specific overrides live in config.<host>.php next to this file
 * (config.onlybirds.at.test.php locally, config.onlybirds.at.php in production).
 * Secrets (content.salt, cookie.key) live in env.php, which is not in git;
 * see env.example.php.
 */

$env = is_file(__DIR__ . '/env.php') ? require __DIR__ . '/env.php' : [];

return array_replace_recursive([
    // one page, several languages: content/home/home.<code>.txt, URLs / and /it (see site/languages)
    'languages'        => true,
    // never redirect by browser language – the default language (German) always answers on /
    'languages.detect' => false,

    'panel' => [
        // Panel UI language for new users; existing users keep their own setting
        'language' => 'en',
    ],

    'debug' => false,
], $env);
