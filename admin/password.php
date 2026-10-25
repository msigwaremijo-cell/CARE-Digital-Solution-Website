<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/partials/layout.php';

require_auth();

$user  = auth_user();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $current = (string) ($_POST['current_password'] ?? '');
    $new     = (string) ($_POST['new_password'] ?? '');
    $confirm = (string) ($_POST['confirm_password'] ?? '');

    $stmt = care_db()->prepare('SELECT password_hash FROM users WHERE id = :id');
    $stmt->execute(['id' => $user['id']]);
    $hash = (string) $stmt->fetchColumn();

    if (!password_verify($current, $hash)) {
        $error = 'Your current password is incorrect.';
    } elseif (strlen($new) < 8) {
        $error = 'The new password must be at least 8 characters long.';
    } elseif ($new !== $confirm) {
        $error = 'The two new password fields do not match.';
    } else {
        $update = care_db()->prepare('UPDATE users SET password_hash = :hash WHERE id = :id');
        $update->execute([
            'hash' => password_hash($new, PASSWORD_DEFAULT),
            'id'   => $user['id'],
        ]);

        flash('Your password has been updated.');
        redirect('password.php');
    }
}

admin_layout_start('Account', 'password');
?>

<div class="admin-card">
  <h2>Change your password</h2>

  <?php if ($error !== ''): ?>
    <div class="admin-flash admin-flash--error"><?= e($error) ?></div>
  <?php endif; ?>

  <form method="post" class="admin-form">
    <?= csrf_field() ?>

    <?php
    admin_field(['name' => 'current_password', 'label' => 'Current password', 'type' => 'password', 'required' => true]);
    admin_field(['name' => 'new_password', 'label' => 'New password', 'type' => 'password', 'required' => true, 'hint' => 'at least 8 characters']);
    admin_field(['name' => 'confirm_password', 'label' => 'Confirm new password', 'type' => 'password', 'required' => true]);
    ?>

    <div class="admin-actions">
      <button type="submit" class="admin-btn">Update password</button>
    </div>
  </form>
</div>

<div class="admin-card">
  <h2>Signed in as</h2>
  <p class="cell-muted" style="margin:0"><?= e($user['name']) ?> &middot; <?= e($user['email']) ?></p>
</div>

<?php admin_layout_end(); ?>
