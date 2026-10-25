<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/partials/layout.php';

require_auth();

$pdo = care_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $formAction = (string) ($_POST['form_action'] ?? '');
    $id = (int) ($_POST['id'] ?? 0);

    if ($formAction === 'delete' && $id > 0) {
        $pdo->prepare('DELETE FROM posts WHERE id = :id')->execute(['id' => $id]);
        flash('Update deleted.');
        redirect('posts.php');
    }

    if ($formAction === 'save') {
        $title = trim((string) ($_POST['title'] ?? ''));

        if ($title === '') {
            flash('A title is required.', 'error');
            redirect($id > 0 ? 'posts.php?action=edit&id=' . $id : 'posts.php?action=new');
        }

        $status = ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft';
        $publishedAt = trim((string) ($_POST['published_at'] ?? ''));

        if ($publishedAt !== '') {
            $publishedAt = str_replace('T', ' ', $publishedAt) . (strlen($publishedAt) === 16 ? ':00' : '');
        } else {
            $publishedAt = $status === 'published' ? date('Y-m-d H:i:s') : null;
        }

        $data = [
            'title'        => $title,
            'excerpt'      => trim((string) ($_POST['excerpt'] ?? '')),
            'body'         => trim((string) ($_POST['body'] ?? '')),
            'status'       => $status,
            'published_at' => $publishedAt,
        ];

        if ($id > 0) {
            $data['slug'] = unique_slug('posts', slugify(trim((string) ($_POST['slug'] ?? '')) ?: $title), $id);
            $data['id'] = $id;

            $pdo->prepare(
                'UPDATE posts SET slug = :slug, title = :title, excerpt = :excerpt,
                        body = :body, status = :status, published_at = :published_at
                 WHERE id = :id'
            )->execute($data);
            flash('Update saved.');
        } else {
            $data['slug'] = unique_slug('posts', slugify($title));

            $pdo->prepare(
                'INSERT INTO posts (slug, title, excerpt, body, status, published_at)
                 VALUES (:slug, :title, :excerpt, :body, :status, :published_at)'
            )->execute($data);
            flash('Update created.');
        }

        redirect('posts.php');
    }
}

$action = (string) ($_GET['action'] ?? 'list');
$editId = (int) ($_GET['id'] ?? 0);

if ($action === 'new' || ($action === 'edit' && $editId > 0)) {
    $post = [
        'id' => 0, 'slug' => '', 'title' => '', 'excerpt' => '', 'body' => '',
        'status' => 'draft', 'published_at' => null,
    ];

    if ($editId > 0) {
        $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->execute(['id' => $editId]);
        $found = $stmt->fetch();

        if (!$found) {
            flash('That update no longer exists.', 'error');
            redirect('posts.php');
        }

        $post = $found;
    }

    $isNew = $editId === 0;
    $publishedValue = $post['published_at'] ? date('Y-m-d\TH:i', strtotime((string) $post['published_at'])) : '';

    admin_layout_start($isNew ? 'Write an update' : 'Edit update', 'posts');
    ?>

    <div class="admin-card">
      <form method="post" class="admin-form admin-form--wide">
        <?= csrf_field() ?>
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= (int) $post['id'] ?>">

        <?php
        admin_field(['name' => 'title', 'label' => 'Title', 'value' => $post['title'], 'required' => true]);
        admin_field(['name' => 'slug', 'label' => 'URL slug', 'value' => $post['slug'], 'hint' => 'leave blank to generate from the title']);
        admin_field(['name' => 'excerpt', 'label' => 'Short summary', 'type' => 'textarea', 'rows' => 3, 'value' => $post['excerpt'], 'hint' => 'shown in listings']);
        admin_field(['name' => 'body', 'label' => 'Full update', 'type' => 'textarea', 'rows' => 14, 'value' => $post['body'], 'hint' => 'blank lines separate paragraphs']);
        ?>

        <div class="admin-grid-2">
          <?php
          admin_field([
              'name' => 'status',
              'label' => 'Status',
              'type' => 'select',
              'value' => $post['status'],
              'options' => ['draft' => 'Draft (hidden)', 'published' => 'Published (live)'],
          ]);
          admin_field(['name' => 'published_at', 'label' => 'Publish date', 'type' => 'datetime-local', 'value' => $publishedValue, 'hint' => 'optional']);
          ?>
        </div>

        <div class="admin-actions">
          <button type="submit" class="admin-btn"><?= $isNew ? 'Create update' : 'Save changes' ?></button>
          <a href="posts.php" class="admin-btn admin-btn--ghost">Cancel</a>
        </div>
      </form>
    </div>

    <?php
    admin_layout_end();
    exit;
}

$rows = $pdo->query('SELECT * FROM posts ORDER BY COALESCE(published_at, created_at) DESC')->fetchAll();

admin_layout_start('News & Updates', 'posts');
?>

<div class="admin-toolbar">
  <p class="cell-muted" style="margin:0"><?= count($rows) ?> update<?= count($rows) === 1 ? '' : 's' ?> in total.</p>
  <a class="admin-btn" href="posts.php?action=new">Write an update</a>
</div>

<div class="admin-card">
  <?php if (!$rows): ?>
    <div class="admin-empty">
      No updates yet. Publish your first announcement — it will appear on the website automatically.
    </div>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr><th>Title</th><th>Status</th><th>Published</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td>
              <strong><?= e($row['title']) ?></strong><br>
              <span class="cell-muted"><?= e($row['slug']) ?></span>
            </td>
            <td>
              <span class="admin-pill admin-pill--<?= $row['status'] === 'published' ? 'on' : 'draft' ?>">
                <?= $row['status'] === 'published' ? 'Published' : 'Draft' ?>
              </span>
            </td>
            <td class="cell-muted"><?= e(nice_date($row['published_at'])) ?></td>
            <td>
              <div class="row-actions">
                <a class="admin-btn admin-btn--ghost admin-btn--sm" href="posts.php?action=edit&amp;id=<?= (int) $row['id'] ?>">Edit</a>
                <form method="post" onsubmit="return confirm('Delete this update permanently?');">
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
