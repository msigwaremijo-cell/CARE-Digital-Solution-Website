<?php
declare(strict_types=1);

/**
 * Inline SVG icon set.
 *
 * Every icon is stroke-based and inherits `currentColor`, matching the
 * `.icon` rule already defined in the public pages. Keeping them here means
 * database rows only store a short key instead of a blob of markup.
 */

function care_icon_keys(): array
{
    return ['monitor', 'chart', 'ai', 'palette', 'printer', 'book', 'cloud', 'grid',
            'lightbulb', 'badge-check', 'trending-up', 'sparkles', 'code',
            'smartphone', 'camera', 'megaphone', 'shield', 'database'];
}

/** Raw inner markup for an icon key. */
function care_icon_paths(string $key): string
{
    $icons = [
        'monitor'     => '<rect x="3" y="4" width="18" height="15" rx="2"/><path d="M8 22h8M12 19v3M7 9h10M7 13h6"/>',
        'chart'       => '<path d="M12 20V10M18 20V4M6 20v-4"/>',
        'ai'          => '<path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/><path d="M8.5 8.5v.01M16 15.5v.01M12 12v.01"/>',
        'palette'     => '<path d="M12 3v18M3 12h18"/><circle cx="12" cy="12" r="8"/><path d="m8 8 8 8m0-8-8 8"/>',
        'printer'     => '<path d="M6 9V2h12V9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/>',
        'book'        => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>',
        'cloud'       => '<path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>',
        'grid'        => '<rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/>',
        'lightbulb'   => '<path d="M9 18h6M10 22h4"/><path d="M12 2a7 7 0 0 0-4 12.7V18h8v-3.3A7 7 0 0 0 12 2Z"/>',
        'badge-check' => '<path d="m9 12 2 2 4-4"/><path d="M12 2 4 5v7c0 5 3.4 8.6 8 10 4.6-1.4 8-5 8-10V5l-8-3Z"/>',
        'trending-up' => '<path d="M3 17l6-6 4 4 8-8M21 7h-6M21 7v6"/>',
        'sparkles'    => '<path d="m12 3 1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9L12 3Z"/><path d="M18 17.5 18.8 19l1.5.8-1.5.8L18 22l-.8-1.5-1.5-.8 1.5-.8.8-1.5Z"/>',
        'code'        => '<path d="m16 18 6-6-6-6M8 6l-6 6 6 6"/>',
        'smartphone'  => '<rect x="6" y="2" width="12" height="20" rx="2.5"/><path d="M11 18h2"/>',
        'camera'      => '<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>',
        'megaphone'   => '<path d="m3 11 15-7v16L3 13v-2Z"/><path d="M7 12v6a2 2 0 0 0 4 0v-4"/>',
        'shield'      => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>',
        'database'    => '<ellipse cx="12" cy="5" rx="8" ry="3"/><path d="M4 5v14c0 1.7 3.6 3 8 3s8-1.3 8-3V5"/><path d="M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/>',
    ];

    return $icons[$key] ?? $icons['monitor'];
}

/** Full `<svg>` element for an icon key. */
function care_icon(string $key, int $size = 24, string $class = 'icon'): string
{
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" aria-hidden="true" focusable="false"'
        . ' style="width:' . $size . 'px;height:' . $size . 'px">'
        . care_icon_paths($key) . '</svg>';
}
