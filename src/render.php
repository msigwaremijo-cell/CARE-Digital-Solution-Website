<?php
declare(strict_types=1);

/**
 * Public-facing rendering layer.
 *
 * Each helper reads published rows and echoes the exact markup the static
 * pages used to contain, so the design stays byte-for-byte identical while
 * the content comes from the database.
 */

require_once __DIR__ . '/icons.php';

/** Published services, in display order. */
function care_published_services(int $limit = 0): array
{
    $sql = 'SELECT * FROM services WHERE is_published = 1 ORDER BY sort_order, id';

    if ($limit > 0) {
        $sql .= ' LIMIT ' . $limit;
    }

    try {
        return care_db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/** Published portfolio items, in display order. */
function care_published_projects(int $limit = 0): array
{
    $sql = 'SELECT * FROM projects WHERE is_published = 1 ORDER BY sort_order, id';

    if ($limit > 0) {
        $sql .= ' LIMIT ' . $limit;
    }

    try {
        return care_db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/** Published news items, newest first. */
function care_published_posts(int $limit = 3): array
{
    $sql = 'SELECT * FROM posts
            WHERE status = \'published\'
              AND (published_at IS NULL OR published_at <= NOW())
            ORDER BY published_at DESC, id DESC
            LIMIT ' . max(1, $limit);

    try {
        return care_db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/** Available styles for the small preview graphic on a portfolio card. */
function care_preview_options(): array
{
    return [
        'hero'   => 'Browser hero',
        'split'  => 'Dashboard',
        'brand'  => 'Brand mark',
        'cards'  => 'Print cards',
        'video'  => 'Video player',
        'shop'   => 'Shop grid',
        'banner' => 'Campaign banner',
    ];
}

/** The `.pv-screen` mock interface for a preview key. */
function care_project_preview_html(string $key): string
{
    $top = '<div class="pv-top"><i></i><i></i><i></i><b></b></div>';

    $bodies = [
        'hero' => '<div class="pv-hero"></div><div class="pv-grid"><span></span><span></span><span></span></div>',
        'split' => '<div class="pv-split"><div class="pv-rail"></div>'
            . '<div class="pv-main"><div class="pv-lines"><span></span><span></span></div>'
            . '<div class="pv-bars"><i style="height:38%"></i><i style="height:62%"></i>'
            . '<i style="height:30%"></i><i style="height:78%"></i></div></div></div>',
        'brand' => '<div class="pv-brand"><div class="pv-mark">CARE</div>'
            . '<div class="pv-swatches"><i style="background:#2563EB"></i>'
            . '<i style="background:#22D3EE"></i><i style="background:#0B1F3A"></i></div></div>',
        'cards' => '<div class="pv-cards"><i></i><i></i></div><div class="pv-lines"><span></span><span></span></div>',
        'video' => '<div class="pv-video"><div class="pv-play">'
            . '<svg class="icon" viewBox="0 0 24 24" style="width:18px;height:18px" aria-hidden="true" focusable="false"><path d="m6 4 14 8-14 8z"/></svg>'
            . '</div></div><div class="pv-timeline"></div>',
        'shop' => '<div class="pv-shop"><i></i><i></i><i></i><i></i></div>'
            . '<div class="pv-lines"><span></span><span></span></div>',
        'banner' => '<div class="pv-banner">Campaign</div><div class="pv-tickets"><i></i><i></i><i></i></div>',
    ];

    $body = $bodies[$key] ?? $bodies['hero'];

    return '<div class="pv-screen">' . $top . '<div class="pv-body">' . $body . '</div></div>';
}

/** Arrow used on every "learn more" style link. */
function care_arrow_icon(int $size = 16): string
{
    return '<svg class="icon" viewBox="0 0 24 24" style="width:' . $size . 'px;height:' . $size . 'px" aria-hidden="true" focusable="false">'
        . '<path d="M5 12h14M13 6l6 6-6 6"/></svg>';
}

/**
 * Full service cards, matching the markup used on the Services page.
 *
 * @param array<int,array<string,mixed>> $services
 */
function care_render_service_cards(array $services): void
{
    foreach ($services as $service) {
        $features = json_list($service['features'] ?? null);
        ?>
        <article class="service-card reveal" data-category="<?= e($service['category']) ?>">
          <div class="service-icon"><?= care_icon((string) $service['icon'], 28) ?></div>
          <h3 class="service-title"><?= e($service['title']) ?></h3>
          <p class="service-description"><?= e($service['summary']) ?></p>
          <div class="service-capabilities">
            <?php foreach ($features as $feature): ?>
              <div class="capability"><?= e($feature) ?></div>
            <?php endforeach; ?>
          </div>
          <a href="contact.php" class="service-link">Discuss This Service <?= care_arrow_icon() ?></a>
        </article>
        <?php
    }
}

/**
 * Compact service cards used in the homepage overview grid.
 *
 * @param array<int,array<string,mixed>> $services
 */
function care_render_service_highlights(array $services): void
{
    foreach ($services as $service) {
        ?>
        <article class="card reveal" style="padding:32px">
          <div style="width:56px;height:56px;border-radius:16px;background:linear-gradient(135deg,var(--accent-soft),var(--accent));color:#fff;margin-bottom:24px;display:grid;place-items:center"><?= care_icon((string) $service['icon'], 28) ?></div>
          <h3 style="font-size:1.15rem;font-weight:800;margin-bottom:12px;letter-spacing:-.02em"><?= e($service['title']) ?></h3>
          <p style="color:var(--muted);font-size:.9rem;line-height:1.6;margin-bottom:20px"><?= e($service['summary']) ?></p>
          <a href="contact.php" style="color:var(--accent);font-weight:700;font-size:.85rem;text-decoration:none;display:inline-flex;align-items:center;gap:6px">Learn More <?= care_arrow_icon() ?></a>
        </article>
        <?php
    }
}

/**
 * Portfolio cards, including the data attributes the filter and detail
 * modal read from.
 *
 * @param array<int,array<string,mixed>> $projects
 */
function care_render_project_cards(array $projects): void
{
    foreach ($projects as $project) {
        $metaTags = json_list($project['meta_tags'] ?? null);
        $detailTags = json_list($project['tags'] ?? null);
        $overlay = trim((string) ($project['overlay'] ?? ''));
        $classes = 'project-card' . (!empty($project['is_wide']) ? ' is-wide' : '') . ' reveal';
        ?>
        <article class="<?= e($classes) ?>" data-category="<?= e($project['category']) ?>"
          data-title="<?= e($project['title']) ?>"
          data-label="<?= e($project['label']) ?>"
          data-summary="<?= e($project['summary']) ?>"
          data-objective="<?= e($project['objective']) ?>"
          data-approach="<?= e($project['approach']) ?>"
          data-tags="<?= e(implode(',', $detailTags)) ?>">
          <div class="project-media">
            <span class="project-badge"><?= e($project['client'] ?: 'Concept Project') ?></span>
            <div class="preview">
              <?= care_project_preview_html((string) ($project['preview'] ?: 'hero')) ?>
            </div>
            <div class="project-overlay">
              <p><?= e($overlay ?: $project['summary']) ?></p>
              <span>View details <?= care_arrow_icon() ?></span>
            </div>
          </div>
          <div class="project-content">
            <div class="project-category"><?= e($project['label']) ?></div>
            <h3 class="project-title"><?= e($project['title']) ?></h3>
            <p class="project-description"><?= e($project['description']) ?></p>
            <?php if ($metaTags): ?>
              <div class="project-meta">
                <?php foreach ($metaTags as $tag): ?>
                  <span class="project-tag"><?= e($tag) ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <button class="project-link" type="button">View project details <?= care_arrow_icon() ?></button>
          </div>
        </article>
        <?php
    }
}

/**
 * News & updates cards used on the homepage.
 *
 * @param array<int,array<string,mixed>> $posts
 */
function care_render_post_cards(array $posts): void
{
    foreach ($posts as $post) {
        $excerpt = trim((string) ($post['excerpt'] ?? ''));
        $body = trim((string) ($post['body'] ?? ''));

        if ($excerpt === '') {
            $excerpt = mb_strimwidth($body, 0, 180, '…');
        }

        $date = $post['published_at'] ?: $post['created_at'];
        ?>
        <article class="card reveal" style="padding:32px;display:flex;flex-direction:column">
          <div style="color:var(--accent);font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.16em;margin-bottom:12px"><?= e(nice_date($date)) ?></div>
          <h3 style="font-size:1.15rem;font-weight:800;margin-bottom:12px;letter-spacing:-.02em"><?= e($post['title']) ?></h3>
          <?php if ($excerpt !== ''): ?>
            <p style="color:var(--muted);font-size:.9rem;line-height:1.6;margin:0 0 16px"><?= e($excerpt) ?></p>
          <?php endif; ?>
          <?php if ($body !== '' && $body !== $excerpt): ?>
            <details style="margin-top:auto">
              <summary style="cursor:pointer;color:var(--accent);font-weight:700;font-size:.85rem">Read more</summary>
              <p style="color:var(--muted);font-size:.9rem;line-height:1.7;margin-top:12px"><?= nl2br(e($body)) ?></p>
            </details>
          <?php endif; ?>
        </article>
        <?php
    }
}
