<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/partials/layout.php';

require_auth();

$pdo = care_db();

/** Portfolio filter categories, matching the buttons on portfolio.html. */
function project_categories(): array
{
    return [
        'web'        => 'Web Design',
        'software'   => 'Software & AI',
        'design'     => 'Graphic Design',
        'branding'   => 'Branding & Printing',
        'multimedia' => 'Multimedia',
        'other'      => 'Other Creative Work',
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $formAction = (string) ($_POST['form_action'] ?? '');
    $id = (int) ($_POST['id'] ?? 0);

    if ($formAction === 'delete' && $id > 0) {
        $pdo->prepare('DELETE FROM projects WHERE id = :id')->execute(['id' => $id]);
        flash('Portfolio item deleted.');
        redirect('projects.php');
    }

    if ($formAction === 'save') {
        $title = trim((string) ($_POST['title'] ?? ''));

        if ($title === '') {
            flash('A title is required.', 'error');
            redirect($id > 0 ? 'projects.php?action=edit&id=' . $id : 'projects.php?action=new');
        }

        $category = array_key_exists((string) $_POST['category'], project_categories())
            ? (string) $_POST['category']
            : 'web';

        $label = trim((string) ($_POST['label'] ?? '')) ?: project_categories()[$category];

        $data = [
            'title'        => $title,
            'category'     => $category,
            'label'        => $label,
            'client'       => trim((string) ($_POST['client'] ?? '')),
            'year'         => trim((string) ($_POST['year'] ?? '')),
            'summary'      => trim((string) ($_POST['summary'] ?? '')),
            'description'  => trim((string) ($_POST['description'] ?? '')),
            'objective'    => trim((string) ($_POST['objective'] ?? '')),
            'approach'     => trim((string) ($_POST['approach'] ?? '')),
            'tags'         => list_to_json((string) ($_POST['tags'] ?? '')),
            'meta_tags'    => list_to_json((string) ($_POST['meta_tags'] ?? '')),
            'is_wide'      => !empty($_POST['is_wide']) ? 1 : 0,
            'is_featured'  => !empty($_POST['is_featured']) ? 1 : 0,
            'sort_order'   => (int) ($_POST['sort_order'] ?? 0),
            'is_published' => !empty($_POST['is_published']) ? 1 : 0,
        ];

        if ($id > 0) {
            $data['slug'] = unique_slug('projects', slugify(trim((string) ($_POST['slug'] ?? '')) ?: $title), $id);
            $data['id'] = $id;

            $sql = 'UPDATE projects SET
                        slug = :slug, title = :title, category = :category, label = :label,
                        client = :client, year = :year, summary = :summary, description = :description,
                        objective = :objective, approach = :approach, tags = :tags, meta_tags = :meta_tags,
                        is_wide = :is_wide, is_featured = :is_featured,
                        sort_order = :sort_order, is_published = :is_published
                    WHERE id = :id';
            $pdo->prepare($sql)->execute($data);
            flash('Portfolio item updated.');
        } else {
            $data['slug'] = unique_slug('projects', slugify($title));
            $sql = 'INSERT INTO projects
                        (slug, title, category, label, client, year, summary, description, objective,
                         approach, tags, meta_tags, is_wide, is_featured, sort_order, is_published)
                    VALUES
                        (:slug, :title, :category, :label, :client, :year, :summary, :description, :objective,
                         :approach, :tags, :meta_tags, :is_wide, :is_featured, :sort_order, :is_published)';
            $pdo->prepare($sql)->execute($data);
            flash('Portfolio item added.');
        }

        redirect('projects.php');
    }
}

$action = (string) ($_GET['action'] ?? 'list');
$editId = (int) ($_GET['id'] ?? 0);

if ($action === 'new' || ($action === 'edit' && $editId > 0)) {
    $project = [
        'id' => 0, 'slug' => '', 'title' => '', 'category' => 'web', 'label' => '', 'client' => '', 'year' => '',
        'summary' => '', 'description' => '', 'objective' => '', 'approach' => '',
        'tags' => null, 'meta_tags' => null, 'is_wide' => 0, 'is_featured' => 0,
        'sort_order' => 0, 'is_published' => 1,
    ];

    if ($editId > 0) {
        $stmt = $pdo->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute(['id' => $editId]);
        $found = $stmt->fetch();

        if (!$found) {
            flash('That portfolio item no longer exists.', 'error');
            redirect('projects.php');
        }

        $project = $found;
    }

    $isNew = $editId === 0;
    admin_layout_start($isNew ? 'Add a portfolio item' : 'Edit portfolio item', 'projects');
    ?>

    <div class="admin-card">
      <form method="post" class="admin-form admin-form--wide">
        <?= csrf_field() ?>
        <input type="hidden" name="form_action" value="save">
        <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">

        <?php
        admin_field(['name' => 'title', 'label' => 'Project title', 'value' => $project['title'], 'required' => true]);
        admin_field(['name' => 'slug', 'label' => 'URL slug', 'value' => $project['slug'], 'hint' => 'leave blank to generate from the title']);
        ?>

        <div class="admin-grid-2">
          <?php
          admin_field(['name' => 'category', 'label' => 'Filter category', 'type' => 'select', 'value' => $project['category'], 'options' => project_categories()]);
          admin_field(['name' => 'label', 'label' => 'Display label', 'value' => $project['label'], 'hint' => 'defaults to the category name']);
          admin_field(['name' => 'client', 'label' => 'Client', 'value' => $project['client'], 'hint' => 'optional — leave blank for concept work']);
          admin_field(['name' => 'year', 'label' => 'Year', 'value' => $project['year'], 'hint' => 'optional']);
          ?>
        </div>

        <?php
        admin_field(['name' => 'summary', 'label' => 'Card summary', 'type' => 'textarea', 'rows' => 3, 'value' => $project['summary'], 'hint' => 'shown in the project detail modal']);
        admin_field(['name' => 'description', 'label' => 'Card description', 'type' => 'textarea', 'rows' => 3, 'value' => $project['description'], 'hint' => 'shown on the card itself']);
        admin_field(['name' => 'objective', 'label' => 'Objective', 'type' => 'textarea', 'rows' => 3, 'value' => $project['objective']]);
        admin_field(['name' => 'approach', 'label' => 'Approach', 'type' => 'textarea', 'rows' => 3, 'value' => $project['approach']]);
        admin_field(['name' => 'tags', 'label' => 'Detail tags', 'type' => 'textarea', 'rows' => 3, 'value' => implode("\n", json_list($project['tags'])), 'hint' => 'one per line — shown in the modal']);
        admin_field(['name' => 'meta_tags', 'label' => 'Card tags', 'type' => 'textarea', 'rows' => 2, 'value' => implode("\n", json_list($project['meta_tags'])), 'hint' => 'one per line — small pills on the card']);
        ?>

        <div class="admin-grid-2">
          <?php
          admin_field(['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'value' => $project['sort_order'], 'hint' => 'lower numbers appear first']);
          admin_field(['name' => 'is_published', 'label' => 'Visibility', 'type' => 'checkbox', 'value' => $project['is_published'], 'checkbox_label' => 'Show on the website']);
          admin_field(['name' => 'is_wide', 'label' => 'Layout', 'type' => 'checkbox', 'value' => $project['is_wide'], 'checkbox_label' => 'Wide card (spans 4 of 6 columns)']);
          admin_field(['name' => 'is_featured', 'label' => 'Highlight', 'type' => 'checkbox', 'value' => $project['is_featured'], 'checkbox_label' => 'Mark as featured']);
          ?>
        </div>

        <div class="admin-actions">
          <button type="submit" class="admin-btn"><?= $isNew ? 'Add project' : 'Save changes' ?></button>
          <a href="projects.php" class="admin-btn admin-btn--ghost">Cancel</a>
        </div>
      </form>
    </div>

    <?php
    admin_layout_end();
    exit;
}

$rows = $pdo->query('SELECT * FROM projects ORDER BY sort_order, title')->fetchAll();

admin_layout_start('Portfolio', 'projects');
?>

<div class="admin-toolbar">
  <p class="cell-muted" style="margin:0"><?= count($rows) ?> item<?= count($rows) === 1 ? '' : 's' ?> in total.</p>
  <a class="admin-btn" href="projects.php?action=new">Add a portfolio item</a>
</div>

<div class="admin-card">
  <?php if (!$rows): ?>
    <div class="admin-empty">No portfolio items yet.</div>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr><th>Title</th><th>Category</th><th>Layout</th><th>Order</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td>
              <strong><?= e($row['title']) ?></strong><br>
              <span class="cell-muted"><?= e($row['slug']) ?></span>
            </td>
            <td class="cell-muted"><?= e($row['label'] ?: $row['category']) ?></td>
            <td class="cell-muted"><?= $row['is_wide'] ? 'Wide' : 'Standard' ?></td>
            <td class="cell-muted"><?= (int) $row['sort_order'] ?></td>
            <td>
              <span class="admin-pill admin-pill--<?= $row['is_published'] ? 'on' : 'off' ?>">
                <?= $row['is_published'] ? 'Published' : 'Hidden' ?>
              </span>
            </td>
            <td>
              <div class="row-actions">
                <a class="admin-btn admin-btn--ghost admin-btn--sm" href="projects.php?action=edit&amp;id=<?= (int) $row['id'] ?>">Edit</a>
                <form method="post" onsubmit="return confirm('Delete this portfolio item permanently?');">
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
