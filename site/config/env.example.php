<?php

/**
 * Template for site/config/env.php (which is git-ignored).
 * Copy this file to env.php on each server and replace both values
 * with fresh random strings, e.g. from `openssl rand -hex 32`.
 */
return [
    'content' => [
        // makes preview and media URLs unguessable
        'salt' => 'replace-with-64-random-hex-characters',
    ],
    'cookie' => [
        // signs cookie values so they cannot be tampered with
        'key' => 'replace-with-64-random-hex-characters',
    ],
];
