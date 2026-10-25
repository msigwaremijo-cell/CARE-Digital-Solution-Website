<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/partials/layout.php';

require_auth();

$pdo = care_db();

$count = static function (string $table, string $where = '') use ($pdo): int {
    return (int) $pdo->query("SELECT COUNT(*) FROM `$table` $where")->fetchColumn();
};

$stats = [
    'Services'        => $count('services'),
    'Portfolio items' => $count('projects'),
    'Published posts' => $count('posts', "WHERE status = 'published'"),
    'Unread messages' => $count('messages', 'WHERE is_read = 0'),
];

$recent = $pdo->query(
    'SELECT id, name, email, subject, is_read, created_at
     FROM messages ORDER BY created_at DESC LIMIT 5'
)->fetchAll();

admin_layout_start('Dashboard', 'dashboard');
?>

<div class="admin-stats">
  <?php foreach ($stats as $label => $value): ?>
    <div class="admin-stat">
      <div class="admin-stat-value"><?= (int) $value ?></div>
      <div class="admin-stat-label"><?= e($label) ?></div>
    </div>
  <?php endforeach; ?>
</div>

<div class="admin-card" style="margin-top:22px">
  <h2>Latest messages</h2>

  <?php if (!$recent): ?>
    <div class="admin-empty">No messages yet. Submissions from the contact form will appear here.</div>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr><th>From</th><th>Subject</th><th>Received</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($recent as $row): ?>
          <tr>
            <td>
              <strong><?= e($row['name']) ?></strong><br>
              <span class="cell-muted"><?= e($row['email']) ?></span>
            </td>
            <td>
              <?= e($row['subject'] ?: '—') ?>
              <?php if (!$row['is_read']): ?>
                <span class="admin-pill admin-pill--draft">New</span>
              <?php endif; ?>
            </td>
            <td class="cell-muted"><?= e(nice_date($row['created_at'])) ?></td>
            <td><a class="admin-btn admin-btn--ghost admin-btn--sm" href="messages.php?id=<?= (int) $row['id'] ?>">Open</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<div class="admin-card">
  <h2>Quick actions</h2>
  <div class="admin-actions">
    <a class="admin-btn" href="services.php?action=new">Add a service</a>
    <a class="admin-btn" href="projects.php?action=new">Add a portfolio item</a>
    <a class="admin-btn" href="posts.php?action=new">Write an update</a>
  </div>
</div>

<?php admin_layout_end(); ?>
