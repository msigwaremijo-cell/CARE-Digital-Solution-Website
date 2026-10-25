<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/icons.php';
require __DIR__ . '/partials/layout.php';

require_auth();

$pdo = care_db();

/** Filter categories, matching the buttons on services.html. */
function service_categories(): array
{
    return [
        'development' => 'Digital Development',
        'creative'    => 'Creative & Branding',
        'printing'    => 'Printing & Supplies',
        'ict'         => 'ICT & Innovation',
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $formAction = (string) ($_POST['form_action'] ?? '');
    $id = (int) ($_POST['id'] ?? 0);

    if ($formAction === 'delete' && $id > 0) {
        $stmt = $pdo->prepare('DELETE FROM services WHERE id = :id');
        $stmt->execute(['id' => $id]);
        flash('Service deleted.');
        redirect('services.php');
    }

    if ($formAction === 'save') {
        $title = trim((string) ($_POST['title'] ?? ''));

        if ($title === '') {
            flash('A title is required.', 'error');
            redirect($id > 0 ? 'services.php?action=edit&id=' . $id : 'services.php?action=new');
        }

        $data = [
            'title'        => $title,
            'category'     => array_key_exists((string) $_POST['category'], service_categories()) ? (string) $_POST['category'] : 'development',
            'icon'         => in_array((string) ($_POST['icon'] ?? ''), care_icon_keys(), true) ? (string) $_POST['icon'] : 'monitor',
            'summary'      => trim((string) ($_POST['summary'] ?? '')),
            'description'  => trim((string) ($_POST['description'] ?? '')),
            'features'     => list_to_json((string) ($_POST['features'] ?? '')),
            'sort_order'   => (int) ($_POST['sort_order'] ?? 0),
            'is_published' => !empty($_POST['is_published']) ? 1 : 0,
        ];

        if ($id > 0) {
            $data['slug'] = unique_slug('services', slugify(trim((string) ($_POST['slug'] ?? '')) ?: $title), $id);
            $data['id'] = $id;

            $sql = 'UPDATE services SET
                        slug = :slug, title = :title, category = :category, icon = :icon,
                        summary = :summary, description = :description, features = :features,
                        sort_order = :sort_order, is_published = :is_published
                    WHERE id = :id';
            $pdo->prepare($sql)->execute($data);
            flash('Service updated.');
        } else {
            $data['slug'] = unique_slug('services', slugify($title));
            $sql = 'INSERT INTO services
                        (slug, title, category, icon, summary, description, features, sort_order, is_published)
                    VALUES
                        (:slug, :title, :category, :icon, :summary, :description, :features, :sort_order, :is_published)';
            $pdo->prepare($sql)->execute($data);
            flash('Service added.');
        }

        redirect('services.php');
    }
}

$action = (string) ($_GET['action'] ?? 'list');
$editId = (int) ($_GET['id'] ?? 0);

// ---- edit / new form ----
if ($action === 'new' || ($action === 'edit' && $editId > 0)) {
    $service = [
        'id' => 0, 'slug' => '', 'title' => '', 'category' => 'development', 'icon' => 'monitor',
        'summary' => '', 'description' => '', 'features' => null, 'sort_order' => 0, 'is_published' => 1,
    ];

    if ($editId > 0) {
        $stmt = $pdo->prepare('SELECT * FROM services WHERE id = :id');
        $stmt->execute(['id' => $editId]);
        $found = $stmt->fetch();

        if (!$found) {
            flash('That service no longer exists.', 'error');
            redirect('services.php');
        }

        $service = $found;
    }

    $isNew = $editId === 0;
    admin_layout_start($isNew ? 'Add a service' : 'Edit service', 'services');
    ?>

    <div class="admin-card">
      <form method="post" class="admin-form admin-form--wide">
        <?= csrf_field() ?>
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= (int) $service['id'] ?>">

        <?php
        admin_field(['name' => 'title', 'label' => 'Title', 'value' => $service['title'], 'required' => true]);
        admin_field(['name' => 'slug', 'label' => 'URL slug', 'value' => $service['slug'], 'hint' => 'leave blank to generate from the title']);
        admin_field(['name' => 'category', 'label' => 'Filter category', 'type' => 'select', 'value' => $service['category'], 'options' => service_categories()]);
        admin_field(['name' => 'icon', 'label' => 'Icon', 'type' => 'select', 'value' => $service['icon'], 'options' => array_combine(care_icon_keys(), care_icon_keys())]);
        admin_field(['name' => 'summary', 'label' => 'Short summary', 'type' => 'textarea', 'rows' => 3, 'value' => $service['summary'], 'hint' => 'shown on the service card']);
        admin_field(['name' => 'description', 'label' => 'Longer description', 'type' => 'textarea', 'rows' => 4, 'value' => $service['description'], 'hint' => 'optional']);
        admin_field(['name' => 'features', 'label' => 'Capabilities', 'type' => 'textarea', 'rows' => 6, 'value' => implode("\n", json_list($service['features'])), 'hint' => 'one per line']);
        ?>

        <div class="admin-grid-2">
          <?php
          admin_field(['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'value' => $service['sort_order'], 'hint' => 'lower numbers appear first']);
          admin_field(['name' => 'is_published', 'label' => 'Visibility', 'type' => 'checkbox', 'value' => $service['is_published'], 'checkbox_label' => 'Show on the website']);
          ?>
        </div>

        <div class="admin-actions">
          <button type="submit" class="admin-btn"><?= $isNew ? 'Add service' : 'Save changes' ?></button>
          <a href="services.php" class="admin-btn admin-btn--ghost">Cancel</a>
        </div>
      </form>
    </div>

    <?php if ($service['icon'] !== ''): ?>
      <div class="admin-card">
        <h2>Icon preview</h2>
        <div class="cell-muted" style="display:flex;align-items:center;gap:12px">
          <?= care_icon((string) $service['icon'], 30) ?>
          <span>You can preview each icon in the dropdown after saving.</span>
        </div>
      </div>
    <?php endif; ?>

    <?php
    admin_layout_end();
    exit;
}

// ---- list ----
$rows = $pdo->query('SELECT * FROM services ORDER BY sort_order, title')->fetchAll();

admin_layout_start('Services', 'services');
?>

<div class="admin-toolbar">
  <p class="cell-muted" style="margin:0"><?= count($rows) ?> service<?= count($rows) === 1 ? '' : 's' ?> in total.</p>
  <a class="admin-btn" href="services.php?action=new">Add a service</a>
</div>

<div class="admin-card">
  <?php if (!$rows): ?>
    <div class="admin-empty">No services yet. Add your first one to get started.</div>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr><th style="width:44px"></th><th>Title</th><th>Category</th><th>Order</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?= care_icon((string) $row['icon'], 22) ?></td>
            <td>
              <strong><?= e($row['title']) ?></strong><br>
              <span class="cell-muted"><?= e($row['slug']) ?></span>
            </td>
            <td class="cell-muted"><?= e(service_categories()[$row['category']] ?? $row['category']) ?></td>
            <td class="cell-muted"><?= (int) $row['sort_order'] ?></td>
            <td>
              <span class="admin-pill admin-pill--<?= $row['is_published'] ? 'on' : 'off' ?>">
                <?= $row['is_published'] ? 'Published' : 'Hidden' ?>
              </span>
            </td>
            <td>
              <div class="row-actions">
                <a class="admin-btn admin-btn--ghost admin-btn--sm" href="services.php?action=edit&amp;id=<?= (int) $row['id'] ?>">Edit</a>
                <form method="post" onsubmit="return confirm('Delete this service permanently?');">
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
