<?php
declare(strict_types=1);

/**
 * Small shared helper set used by both the public pages and the admin area.
 * No framework, no dependencies.
 */

/** Escape a value for safe output in HTML. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Session-backed one-shot message. */
function flash(?string $message = null, string $type = 'success'): ?array
{
    if ($message !== null) {
        $_SESSION['flash'] = ['message' => $message, 'type' => $type];
        return null;
    }

    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    return $flash;
}

/** Redirect and stop execution. */
function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

/**
 * Read a setting from the database, memoised for the request.
 */
function setting(string $key, string $default = ''): string
{
    static $cache = null;

    if ($cache === null) {
        $cache = [];
        try {
            foreach (care_db()->query('SELECT setting_key, setting_value FROM settings') as $row) {
                $cache[$row['setting_key']] = (string) $row['setting_value'];
            }
        } catch (Throwable $e) {
            $cache = [];
        }
    }

    return $cache[$key] ?? $default;
}

/** Turn a title into a URL-safe slug. */
function slugify(string $text): string
{
    $slug = strtolower(trim($text));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
    $slug = trim($slug, '-');

    return $slug === '' ? 'item-' . time() : $slug;
}

/**
 * Ensure a slug is unique within a table, appending -2, -3 ... if needed.
 */
function unique_slug(string $table, string $slug, ?int $ignoreId = null): string
{
    $candidate = $slug;
    $suffix = 2;

    while (true) {
        $sql = "SELECT COUNT(*) FROM `$table` WHERE slug = :slug";
        $params = ['slug' => $candidate];

        if ($ignoreId !== null) {
            $sql .= ' AND id <> :id';
            $params['id'] = $ignoreId;
        }

        $stmt = care_db()->prepare($sql);
        $stmt->execute($params);

        if ((int) $stmt->fetchColumn() === 0) {
            return $candidate;
        }

        $candidate = $slug . '-' . $suffix++;
    }
}

/** CSRF token for the current session. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** Abort the request when the submitted CSRF token is invalid. */
function verify_csrf(): void
{
    $submitted = $_POST['csrf_token'] ?? '';

    if (!is_string($submitted) || !hash_equals(csrf_token(), $submitted)) {
        http_response_code(419);
        exit('Your session expired. Please go back and try again.');
    }
}

/**
 * Build a wa.me link from a stored number (any format) plus an optional message.
 */
function whatsapp_link(string $number, string $message = ''): string
{
    $digits = preg_replace('/\D+/', '', $number) ?? '';
    $link = 'https://wa.me/' . $digits;

    if ($message !== '') {
        $link .= '?text=' . rawurlencode($message);
    }

    return $link;
}

/** Format a stored phone number for display, e.g. 0613516832 -> 0613 516 832. */
function phone_display(string $number): string
{
    $digits = preg_replace('/\D+/', '', $number) ?? '';

    if (strlen($digits) === 10) {
        return substr($digits, 0, 4) . ' ' . substr($digits, 4, 3) . ' ' . substr($digits, 7, 3);
    }

    return $digits;
}

/** Format a datetime for display in the admin area. */
function nice_date(?string $datetime): string
{
    if (!$datetime) {
        return '—';
    }

    $ts = strtotime($datetime);

    return $ts ? date('j M Y, H:i', $ts) : '—';
}

/** Decode a JSON column into an array, tolerating plain text and nulls. */
function json_list(?string $value): array
{
    if ($value === null || trim($value) === '') {
        return [];
    }

    $decoded = json_decode($value, true);

    if (is_array($decoded)) {
        return array_values(array_filter($decoded, static fn ($v) => $v !== null && $v !== ''));
    }

    return array_values(array_filter(array_map('trim', explode(',', $value)), static fn ($v) => $v !== ''));
}

/** Encode a newline or comma separated textarea value into a JSON array. */
function list_to_json(?string $value): ?string
{
    $items = json_list($value);

    return $items === [] ? null : json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
