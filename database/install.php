<?php
declare(strict_types=1);

/**
 * Creates the care_digital_solution_db schema and seeds baseline data.
 *
 * Safe to re-run: every statement is idempotent and seeds are insert-if-missing.
 *
 * Usage:  php database/install.php
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('This installer must be run from the command line.');
}

$config = require __DIR__ . '/../src/config.php';

$database = $config['DB_DATABASE'] ?? '';
$host     = $config['DB_HOST'] ?? '127.0.0.1';
$port     = $config['DB_PORT'] ?? '3306';
$user     = $config['DB_USERNAME'] ?? 'root';
$password = $config['DB_PASSWORD'] ?? '';

if ($database === '') {
    exit("DB_DATABASE is not set in .env\n");
}

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// 1. Create the database itself.
$server = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $password, $options);
$server->exec(
    "CREATE DATABASE IF NOT EXISTS `$database`
     CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
);
echo "Database `$database` ready.\n";

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4", $user, $password, $options);

// 2. Tables.
$tables = [
    'users' => "
        CREATE TABLE IF NOT EXISTS users (
            id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name          VARCHAR(120) NOT NULL,
            email         VARCHAR(190) NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY users_email_unique (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'settings' => "
        CREATE TABLE IF NOT EXISTS settings (
            setting_key   VARCHAR(80) NOT NULL,
            setting_value TEXT NULL,
            PRIMARY KEY (setting_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'services' => "
        CREATE TABLE IF NOT EXISTS services (
            id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
            slug         VARCHAR(160) NOT NULL,
            title        VARCHAR(160) NOT NULL,
            category     VARCHAR(40)  NOT NULL DEFAULT 'development',
            summary      VARCHAR(400) NULL,
            description  TEXT NULL,
            icon         VARCHAR(40)  NULL,
            features     TEXT NULL,
            sort_order   INT NOT NULL DEFAULT 0,
            is_published TINYINT(1) NOT NULL DEFAULT 1,
            created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY services_slug_unique (slug),
            KEY services_sort (sort_order)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'projects' => "
        CREATE TABLE IF NOT EXISTS projects (
            id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
            slug         VARCHAR(160) NOT NULL,
            title        VARCHAR(160) NOT NULL,
            category     VARCHAR(40)  NOT NULL DEFAULT 'web',
            label        VARCHAR(80)  NOT NULL DEFAULT 'Web Design',
            client       VARCHAR(160) NULL,
            year         VARCHAR(12)  NULL,
            summary      VARCHAR(400) NULL,
            description  TEXT NULL,
            objective    TEXT NULL,
            approach     TEXT NULL,
            tags         TEXT NULL,
            meta_tags    TEXT NULL,
            preview      VARCHAR(40)  NOT NULL DEFAULT 'hero',
            overlay      VARCHAR(200) NULL,
            is_wide      TINYINT(1) NOT NULL DEFAULT 0,
            is_featured  TINYINT(1) NOT NULL DEFAULT 0,
            sort_order   INT NOT NULL DEFAULT 0,
            is_published TINYINT(1) NOT NULL DEFAULT 1,
            created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY projects_slug_unique (slug),
            KEY projects_sort (sort_order)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'posts' => "
        CREATE TABLE IF NOT EXISTS posts (
            id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
            slug         VARCHAR(160) NOT NULL,
            title        VARCHAR(190) NOT NULL,
            excerpt      VARCHAR(400) NULL,
            body         MEDIUMTEXT NULL,
            status       ENUM('draft','published') NOT NULL DEFAULT 'draft',
            published_at DATETIME NULL,
            created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY posts_slug_unique (slug),
            KEY posts_status (status, published_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'messages' => "
        CREATE TABLE IF NOT EXISTS messages (
            id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name       VARCHAR(120) NOT NULL,
            email      VARCHAR(190) NOT NULL,
            phone      VARCHAR(40)  NULL,
            subject    VARCHAR(190) NULL,
            message    TEXT NOT NULL,
            is_read    TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY messages_read (is_read, created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
];

foreach ($tables as $name => $sql) {
    $pdo->exec($sql);
    echo "Table `$name` ready.\n";
}

// 2b. Add columns introduced after the first release, so an existing
//     installation picks them up without dropping any content.
$lateColumns = [
    'projects' => [
        'preview' => "VARCHAR(40) NOT NULL DEFAULT 'hero' AFTER meta_tags",
        'overlay' => "VARCHAR(200) NULL AFTER preview",
    ],
];

foreach ($lateColumns as $table => $columns) {
    $existing = $pdo->prepare(
        'SELECT COLUMN_NAME FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :table'
    );
    $existing->execute(['db' => $database, 'table' => $table]);
    $present = array_column($existing->fetchAll(), 'COLUMN_NAME');

    foreach ($columns as $column => $definition) {
        if (in_array($column, $present, true)) {
            continue;
        }

        $pdo->exec("ALTER TABLE `$table` ADD COLUMN `$column` $definition");
        echo "Added column `$table`.`$column`.\n";
    }
}

// 3. Seed the admin account (only if no user exists yet).
$userCount = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();

if ($userCount === 0) {
    $initialPassword = 'CareAdmin@2026';
    $stmt = $pdo->prepare(
        'INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :hash)'
    );
    $stmt->execute([
        'name'  => 'CARE Administrator',
        'email' => 'admin@caredigitalsolutions.co.tz',
        'hash'  => password_hash($initialPassword, PASSWORD_DEFAULT),
    ]);

    echo "\nAdmin account created:\n";
    echo "  Email:    admin@caredigitalsolutions.co.tz\n";
    echo "  Password: $initialPassword\n";
    echo "  Change it at /admin/password.php after your first login.\n";
} else {
    echo "\nAdmin account already exists - left untouched.\n";
}

// 4. Seed site settings (insert-if-missing, so your edits are never overwritten).
$settings = [
    'site_email'        => 'info@caredigitalsolutions.co.tz',
    'site_phone_1'      => '0613516832',
    'site_phone_2'      => '0743939008',
    'whatsapp_1'        => '255613516832',
    'whatsapp_2'        => '255743939008',
    'site_tagline'      => 'Connecting Ideas, Empowering Businesses.',
    'site_domain'       => 'caredigitalsolutions.co.tz',
];

$insert = $pdo->prepare(
    'INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v)
     ON DUPLICATE KEY UPDATE setting_key = setting_key'
);

foreach ($settings as $key => $value) {
    $insert->execute(['k' => $key, 'v' => $value]);
}
echo "\n" . count($settings) . " default settings ready.\n";

echo "\nInstallation complete.\n";
