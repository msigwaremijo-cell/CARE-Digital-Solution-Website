<?php
declare(strict_types=1);

/**
 * Shared admin chrome: sidebar navigation, topbar and page shell.
 */

function admin_nav_items(): array
{
    return [
        ['href' => 'index.php',    'label' => 'Dashboard',      'key' => 'dashboard'],
        ['href' => 'services.php', 'label' => 'Services',       'key' => 'services'],
        ['href' => 'projects.php', 'label' => 'Portfolio',      'key' => 'projects'],
        ['href' => 'posts.php',    'label' => 'News & Updates', 'key' => 'posts'],
        ['href' => 'messages.php', 'label' => 'Messages',       'key' => 'messages'],
        ['href' => 'settings.php', 'label' => 'Site Settings',  'key' => 'settings'],
        ['href' => 'password.php', 'label' => 'Account',        'key' => 'password'],
    ];
}

/** Number of unread contact messages, shown as a badge in the sidebar. */
function admin_unread_count(): int
{
    static $count = null;

    if ($count === null) {
        try {
            $count = (int) care_db()->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
        } catch (Throwable $e) {
            $count = 0;
        }
    }

    return $count;
}

function admin_layout_start(string $title, string $active = ''): void
{
    $user = auth_user();
    ?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($title) ?> — CARE Admin</title>
<link rel="stylesheet" href="assets/admin.css">
</head>
<body>
<div class="admin-shell">
  <aside class="admin-sidebar">
    <div class="admin-brand">
      <span class="admin-brand-mark">C</span>
      <span class="admin-brand-text">
        <strong>CARE Digital</strong>
        <small>Content Manager</small>
      </span>
    </div>
    <nav class="admin-nav">
      <?php foreach (admin_nav_items() as $item): ?>
        <a href="<?= e($item['href']) ?>" class="admin-nav-link<?= $active === $item['key'] ? ' is-active' : '' ?>">
          <?= e($item['label']) ?>
          <?php if ($item['key'] === 'messages' && admin_unread_count() > 0): ?>
            <span class="admin-badge"><?= admin_unread_count() ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="admin-sidebar-footer">
      <a href="../index.php" class="admin-ghost-link" target="_blank" rel="noopener">View website</a>
      <a href="logout.php" class="admin-ghost-link">Sign out</a>
    </div>
  </aside>
  <main class="admin-main">
    <header class="admin-topbar">
      <h1><?= e($title) ?></h1>
      <span class="admin-user"><?= e($user['email'] ?? '') ?></span>
    </header>
    <?php if ($message = flash()): ?>
      <div class="admin-flash admin-flash--<?= e($message['type']) ?>"><?= e($message['message']) ?></div>
    <?php endif; ?>
<?php
}

function admin_layout_end(): void
{
    ?>
  </main>
</div>
</body>
</html><?php
}

/**
 * Render an input field for the resource forms.
 *
 * @param array<string,mixed> $field
 */
function admin_field(array $field): void
{
    $name     = $field['name'];
    $label    = $field['label'];
    $type     = $field['type'] ?? 'text';
    $value    = $field['value'] ?? '';
    $hint     = $field['hint'] ?? '';
    $required = !empty($field['required']);
    $rows     = (int) ($field['rows'] ?? 5);
    $options  = $field['options'] ?? [];
    $id       = 'field-' . $name;

    echo '<div class="admin-field">';
    echo '<label for="' . e($id) . '">' . e($label);
    if ($hint !== '') {
        echo ' <span class="admin-hint">' . e($hint) . '</span>';
    }
    echo '</label>';

    $attrs = 'id="' . e($id) . '" name="' . e($name) . '"' . ($required ? ' required' : '');

    if ($type === 'textarea') {
        echo '<textarea ' . $attrs . ' rows="' . $rows . '">' . e((string) $value) . '</textarea>';
    } elseif ($type === 'select') {
        echo '<select ' . $attrs . '>';
        foreach ($options as $optValue => $optLabel) {
            $selected = (string) $optValue === (string) $value ? ' selected' : '';
            echo '<option value="' . e((string) $optValue) . '"' . $selected . '>' . e($optLabel) . '</option>';
        }
        echo '</select>';
    } elseif ($type === 'checkbox') {
        $checked = $value ? ' checked' : '';
        echo '<label class="admin-checkbox"><input type="hidden" name="' . e($name) . '" value="0">';
        echo '<input type="checkbox" id="' . e($id) . '" name="' . e($name) . '" value="1"' . $checked . '>';
        echo '<span>' . e($field['checkbox_label'] ?? 'Enabled') . '</span></label>';
    } else {
        echo '<input type="' . e($type) . '" ' . $attrs . ' value="' . e((string) $value) . '">';
    }

    echo '</div>';
}
