<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/partials/layout.php';

require_auth();

/**
 * The site settings the public pages read. Only these keys can ever be saved,
 * so the form cannot be used to write arbitrary rows into the table.
 *
 * @return array<string,array<string,mixed>>
 */
function admin_setting_fields(): array
{
    return [
        'site_email' => [
            'label' => 'Contact email address',
            'type'  => 'email',
            'hint'  => 'shown in the footer and contact page',
        ],
        'site_phone_1' => [
            'label' => 'Primary phone number',
            'type'  => 'text',
            'hint'  => 'local format, e.g. 0613516832',
        ],
        'site_phone_2' => [
            'label' => 'Secondary phone number',
            'type'  => 'text',
            'hint'  => 'local format, e.g. 0743939008',
        ],
        'whatsapp_1' => [
            'label' => 'Primary WhatsApp number',
            'type'  => 'text',
            'hint'  => 'international format, digits only, e.g. 255613516832',
        ],
        'whatsapp_2' => [
            'label' => 'Secondary WhatsApp number',
            'type'  => 'text',
            'hint'  => 'international format, digits only, e.g. 255743939008',
        ],
        'site_tagline' => [
            'label' => 'Tagline',
            'type'  => 'text',
        ],
        'site_domain' => [
            'label' => 'Domain',
            'type'  => 'text',
            'hint'  => 'without https://, e.g. caredigitalsolutions.co.tz',
        ],
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $fields  = admin_setting_fields();
    $update  = care_db()->prepare(
        'INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v)
         ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
    );

    foreach ($fields as $key => $field) {
        $value = trim((string) ($_POST[$key] ?? ''));

        if (($field['type'] ?? 'text') === 'email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            flash('“' . $field['label'] . '” is not a valid email address.', 'error');
            redirect('settings.php');
        }

        $update->execute(['k' => $key, 'v' => $value]);
    }

    flash('Site settings saved.');
    redirect('settings.php');
}

admin_layout_start('Site Settings', 'settings');
?>

<div class="admin-card">
  <h2>Contact details</h2>
  <p class="cell-muted" style="margin-top:0">
    These values are used in the header, footer and contact page across the website.
    Change them here instead of editing the pages by hand.
  </p>

  <form method="post" class="admin-form">
    <?= csrf_field() ?>

    <?php foreach (admin_setting_fields() as $key => $field): ?>
      <?php
      admin_field([
          'name'  => $key,
          'label' => $field['label'],
          'type'  => $field['type'] ?? 'text',
          'hint'  => $field['hint'] ?? '',
          'value' => setting($key),
      ]);
      ?>
    <?php endforeach; ?>

    <div class="admin-actions">
      <button type="submit" class="admin-btn">Save settings</button>
    </div>
  </form>
</div>

<?php admin_layout_end(); ?>
