<?php
declare(strict_types=1);

/**
 * Session based admin authentication.
 * Passwords are stored with password_hash(); nothing is stored in plain text.
 */

function auth_user(): ?array
{
    static $user = false;

    if ($user !== false) {
        return $user;
    }

    $id = $_SESSION['user_id'] ?? null;

    if (!$id) {
        return $user = null;
    }

    $stmt = care_db()->prepare('SELECT id, name, email FROM users WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $found = $stmt->fetch();

    if (!$found) {
        unset($_SESSION['user_id']);
        return $user = null;
    }

    return $user = $found;
}

function auth_check(): bool
{
    return auth_user() !== null;
}

/** Verify credentials and start the session. Returns false on bad credentials. */
function auth_attempt(string $email, string $password): bool
{
    $stmt = care_db()->prepare('SELECT id, password_hash FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    // Upgrade the stored hash if PHP's default algorithm has moved on.
    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
        $update = care_db()->prepare('UPDATE users SET password_hash = :hash WHERE id = :id');
        $update->execute([
            'hash' => password_hash($password, PASSWORD_DEFAULT),
            'id'   => $user['id'],
        ]);
    }

    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) $user['id'];

    return true;
}

function auth_logout(): void
{
    $_SESSION = [];
    session_destroy();
}

/** Guard the admin area. */
function require_auth(): void
{
    if (!auth_check()) {
        redirect('login.php');
    }
}
