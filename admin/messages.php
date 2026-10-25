<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/partials/layout.php';

require_auth();

$pdo = care_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $id = (int) ($_POST['id'] ?? 0);
    $formAction = (string) ($_POST['form_action'] ?? '');

    if ($formAction === 'delete' && $id > 0) {
        $pdo->prepare('DELETE FROM messages WHERE id = :id')->execute(['id' => $id]);
        flash('Message deleted.');
        redirect('messages.php');
    }

    if ($formAction === 'toggle-read' && $id > 0) {
        $pdo->prepare('UPDATE messages SET is_read = 1 - is_read WHERE id = :id')->execute(['id' => $id]);
        flash('Message updated.');
        redirect('messages.php?id=' . $id);
    }
}

$openId = (int) ($_GET['id'] ?? 0);
$open = null;

if ($openId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM messages WHERE id = :id');
    $stmt->execute(['id' => $openId]);
    $open = $stmt->fetch() ?: null;

    // Opening a message marks it as read.
    if ($open && !$open['is_read']) {
        $pdo->prepare('UPDATE messages SET is_read = 1 WHERE id = :id')->execute(['id' => $openId]);
        $open['is_read'] = 1;
    }
}

if ($open) {
    admin_layout_start('Message from ' . $open['name'], 'messages');
    ?>

    <div class="admin-toolbar">
      <a class="admin-btn admin-btn--ghost admin-btn--sm" href="messages.php">&larr; All messages</a>
    </div>

    <div class="admin-card">
      <h2><?= e($open['subject'] ?: 'No subject') ?></h2>

      <table class="admin-table">
        <tbody>
          <tr><th style="width:130px">From</th><td><strong><?= e($open['name']) ?></strong></td></tr>
          <tr><th>Email</th><td><a href="mailto:<?= e($open['email']) ?>"><?= e($open['email']) ?></a></td></tr>
          <?php if (!empty($open['phone'])): ?>
            <tr><th>Phone</th><td><a href="tel:<?= e($open['phone']) ?>"><?= e($open['phone']) ?></a></td></tr>
          <?php endif; ?>
          <tr><th>Received</th><td class="cell-muted"><?= e(nice_date($open['created_at'])) ?></td></tr>
        </tbody>
      </table>

      <h2 style="margin-top:22px">Message</h2>
      <div class="admin-message-body"><?= e($open['message']) ?></div>

      <div class="admin-actions" style="margin-top:20px">
        <a class="admin-btn" href="mailto:<?= e($open['email']) ?>?subject=<?= rawurlencode('Re: ' . ($open['subject'] ?: 'Your enquiry')) ?>">Reply by email</a>
        <?php if (!empty($open['phone'])): ?>
          <a class="admin-btn" href="<?= e(whatsapp_link($open['phone'], 'Hello ' . $open['name'] . ', thank you for contacting CARE Digital Solutions.')) ?>" target="_blank" rel="noopener">Reply on WhatsApp</a>
        <?php endif; ?>
        <form method="post" onsubmit="return confirm('Delete this message permanently?');">
          <?= csrf_field() ?>
          <input type="hidden" name="form_action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $open['id'] ?>">
          <button type="submit" class="admin-btn admin-btn--danger">Delete message</button>
        </form>
      </div>
    </div>

    <?php
    admin_layout_end();
    exit;
}

$rows = $pdo->query('SELECT * FROM messages ORDER BY created_at DESC')->fetchAll();

admin_layout_start('Messages', 'messages');
?>

<div class="admin-card">
  <?php if (!$rows): ?>
    <div class="admin-empty">
      No messages yet. Submissions from the contact form will land here.
    </div>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr><th>From</th><th>Subject</th><th>Received</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr<?= $row['is_read'] ? '' : ' style="background:#FAFCFF"' ?>>
            <td>
              <strong><?= e($row['name']) ?></strong>
              <?php if (!$row['is_read']): ?>
                <span class="admin-pill admin-pill--draft">New</span>
              <?php endif; ?>
              <br><span class="cell-muted"><?= e($row['email']) ?></span>
            </td>
            <td><?= e($row['subject'] ?: '—') ?></td>
            <td class="cell-muted"><?= e(nice_date($row['created_at'])) ?></td>
            <td>
              <div class="row-actions">
                <a class="admin-btn admin-btn--ghost admin-btn--sm" href="messages.php?id=<?= (int) $row['id'] ?>">Open</a>
                <form method="post" onsubmit="return confirm('Delete this message permanently?');">
                  <?= csrf_field() ?>
                  <input type="hidden" name="form_action" value="delete">
                  <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                  <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php admin_layout_end(); ?>
