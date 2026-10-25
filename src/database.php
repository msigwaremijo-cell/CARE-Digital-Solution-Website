<?php
declare(strict_types=1);

/**
 * Shared PDO connection for the whole site.
 */
function care_db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = require __DIR__ . '/config.php';

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $config['DB_HOST'] ?? '127.0.0.1',
        $config['DB_PORT'] ?? '3306',
        $config['DB_DATABASE'] ?? ''
    );

    $pdo = new PDO($dsn, $config['DB_USERNAME'] ?? 'root', $config['DB_PASSWORD'] ?? '', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    return $pdo;
}
