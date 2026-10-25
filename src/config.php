<?php
declare(strict_types=1);

/**
 * Minimal .env reader.
 *
 * Deliberately dependency-free — this project has no Composer install, so
 * pulling in vlucas/phpdotenv would mean adding a vendor directory and a
 * build step purely to read six lines of config.
 *
 * The function is guarded so the file can be safely required more than once
 * per request. Note that `require_once` must NOT be used by callers: on a
 * repeat include it returns true instead of the config array.
 *
 * @return array<string,string>
 */
if (!function_exists('care_load_env')) {
    function care_load_env(string $path): array
    {
        if (!is_file($path)) {
            throw new RuntimeException('Missing .env file at: ' . $path);
        }

        $values = [];

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Strip a matching pair of surrounding quotes, e.g. APP_NAME="CARE".
            if (strlen($value) > 1
                && ($value[0] === '"' || $value[0] === "'")
                && $value[0] === substr($value, -1)
            ) {
                $value = substr($value, 1, -1);
            }

            $values[$key] = $value;
        }

        return $values;
    }
}

return care_load_env(dirname(__DIR__) . '/.env');
