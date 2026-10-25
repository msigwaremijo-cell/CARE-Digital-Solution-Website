<?php
declare(strict_types=1);

/**
 * Front controller shared by every page (public and admin).
 * Include this first, then use the helpers it pulls in.
 */

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
    ]);
}

require __DIR__ . '/database.php';
require __DIR__ . '/helpers.php';
require __DIR__ . '/auth.php';

/** Config array from .env, handy for page titles and the like. */
function care_config(): array
{
    static $config = null;

    return $config ??= require __DIR__ . '/config.php';
}
