<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

if (auth_check()) {
    redirect('index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    // Small delay to blunt trivial brute-force attempts.
    usleep(300000);

    if (auth_attempt($email, $password)) {
        redirect('index.php');
    }

    $error = 'Those credentials do not match our records.';
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Sign in — CARE Admin</title>
<link rel="stylesheet" href="assets/admin.css">
</head>
<body class="admin-login">
  <div class="admin-login-card">
    <h1>Content Manager</h1>
    <p>CARE Digital Solutions</p>

    <?php if ($error !== ''): ?>
      <div class="admin-login-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="admin-form">
      <?= csrf_field() ?>
      <div class="admin-field">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" required autofocus
               value="<?= e((string) ($_POST['email'] ?? '')) ?>">
      </div>
      <div class="admin-field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="admin-actions">
        <button type="submit" class="admin-btn">Sign in</button>
      </div>
    </form>

    <p class="admin-login-foot"><a href="../index.php">Back to website</a></p>
  </div>
</body>
</html>
