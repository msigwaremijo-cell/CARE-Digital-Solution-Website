<?php
declare(strict_types=1);

/**
 * Seeds the existing website content into the database so the pages look
 * identical to before the switch to dynamic rendering.
 *
 * Runs only when a table is empty, so it will never duplicate or overwrite
 * content you have since edited in the admin area.
 *
 * Usage:  php database/seed.php
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('This seeder must be run from the command line.');
}

require __DIR__ . '/../src/config.php';

$config = require __DIR__ . '/../src/config.php';

$pdo = new PDO(
    sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $config['DB_HOST'],
        $config['DB_PORT'],
        $config['DB_DATABASE']
    ),
    $config['DB_USERNAME'],
    $config['DB_PASSWORD'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

$services = [
    [
        'title' => 'Website Design & Development',
        'category' => 'development',
        'icon' => 'monitor',
        'summary' => 'Professional, responsive websites designed to strengthen business presence, communicate value, and provide excellent user experiences.',
        'features' => ['Corporate websites', 'Landing pages', 'Portfolio websites', 'Responsive web interfaces', 'Website redesigns', 'User-focused digital experiences'],
    ],
    [
        'title' => 'Software Development & Business Systems',
        'category' => 'development',
        'icon' => 'chart',
        'summary' => 'Custom digital applications and business systems designed to improve processes, organize information, and support business operations.',
        'features' => ['Custom web applications', 'Business management systems', 'Workflow solutions', 'Database-driven applications', 'System integrations', 'Business process digitization'],
    ],
    [
        'title' => 'Artificial Intelligence & Digital Innovation',
        'category' => 'ict',
        'icon' => 'ai',
        'summary' => 'Practical exploration of AI and emerging technologies to support productivity, automation, and innovative digital experiences.',
        'features' => ['AI-assisted workflows', 'Intelligent digital features', 'Business process automation concepts', 'AI integration planning', 'Digital innovation consulting', 'Technology exploration and prototyping'],
    ],
    [
        'title' => 'Graphic Design & Brand Identity',
        'category' => 'creative',
        'icon' => 'palette',
        'summary' => 'Creative visual communication that helps businesses establish a recognizable, consistent, and professional brand identity.',
        'features' => ['Logo design', 'Visual identity development', 'Posters and flyers', 'Banners and brochures', 'Business cards', 'Social media graphics'],
    ],
    [
        'title' => 'Printing & Branding Services',
        'category' => 'printing',
        'icon' => 'printer',
        'summary' => 'Professional printing and branding solutions for businesses, organizations, events, and promotional activities.',
        'features' => ['Printed promotional materials', 'Branded business stationery', 'Signage and banners', 'Merchandise design', 'Branded apparel design', 'Marketing and event materials'],
    ],
    [
        'title' => 'Stationery & Office Supplies',
        'category' => 'printing',
        'icon' => 'book',
        'summary' => 'Essential office stationery and business supplies to support everyday administrative and professional activities.',
        'features' => ['Office stationery', 'Writing materials', 'Printing supplies', 'Business documents', 'Office essentials', 'Related stationery products'],
    ],
    [
        'title' => 'ICT Support & Consultancy',
        'category' => 'ict',
        'icon' => 'cloud',
        'summary' => 'Technology assistance and practical guidance to help businesses maintain reliable systems and make informed technology decisions.',
        'features' => ['Technical troubleshooting', 'Software installation', 'Basic system configuration', 'Technology guidance', 'ICT support', 'Digital improvement consulting'],
    ],
    [
        'title' => 'Multimedia & Video Editing',
        'category' => 'creative',
        'icon' => 'grid',
        'summary' => 'Engaging multimedia content designed to communicate ideas, promote brands, and tell compelling visual stories.',
        'features' => ['Video editing', 'Promotional videos', 'Digital content production', 'Motion graphics', 'Social media video content', 'Visual storytelling'],
    ],
];

$projects = [
    [
        'title' => 'Corporate Website Concept',
        'category' => 'web', 'label' => 'Web Design', 'is_wide' => 1,
        'preview' => 'hero',
        'overlay' => 'Modular corporate layout with a clear journey from first impression to enquiry.',
        'summary' => 'A responsive corporate website concept built around clear structure, calm typography and a straightforward route to enquiry.',
        'description' => 'A responsive corporate website concept featuring a modern layout, clean typography and an optimised user experience.',
        'objective' => "Present a company's services clearly, build credibility in the first few seconds and make contact effortless on any device.",
        'approach' => 'A modular page system with generous white space, a restrained navy and blue palette and a content hierarchy that leads naturally to the enquiry form.',
        'tags' => ['Responsive Layout', 'Design System', 'Web Performance'],
        'meta_tags' => ['Responsive', 'Modern'],
    ],
    [
        'title' => 'Business System Dashboard',
        'category' => 'software', 'label' => 'Software & AI', 'is_wide' => 0,
        'preview' => 'split',
        'overlay' => 'Operational data organised into one calm, legible view.',
        'summary' => 'A dashboard concept for internal business systems, designed so decision makers can read performance at a glance.',
        'description' => 'A dashboard concept for business management systems with clear data visualisation and an intuitive interface layout.',
        'objective' => 'Turn scattered operational data into one calm, legible view that supports faster day-to-day decisions.',
        'approach' => 'A fixed navigation rail, prioritised data blocks and a chart language that stays readable on smaller laptop screens.',
        'tags' => ['Dashboard UI', 'Data Visualisation', 'Design System'],
        'meta_tags' => ['Dashboard', 'Analytics'],
    ],
    [
        'title' => 'Brand Identity Concept',
        'category' => 'design', 'label' => 'Graphic Design', 'is_wide' => 0,
        'preview' => 'brand',
        'overlay' => 'A structured identity system built to stay consistent.',
        'summary' => 'A complete brand identity concept including logo design, colour palette, typography and brand guidelines.',
        'description' => 'A complete brand identity concept including logo design, colour palette, typography, and brand guidelines.',
        'objective' => 'Give a growing business one consistent visual identity that works across both print and digital touchpoints.',
        'approach' => 'A structured identity system — a flexible primary mark, defined colour and type scales, and simple usage rules so the brand stays consistent as it grows.',
        'tags' => ['Logo Design', 'Colour System', 'Typography', 'Brand Guidelines'],
        'meta_tags' => ['Logo', 'Branding'],
    ],
    [
        'title' => 'Print Materials Concept',
        'category' => 'branding', 'label' => 'Branding & Printing', 'is_wide' => 0,
        'preview' => 'cards',
        'overlay' => 'Brand identity carried into premium print touchpoints.',
        'summary' => 'A collection of branded print materials including business cards, brochures and promotional items.',
        'description' => 'A collection of branded print materials including business cards, brochures, and promotional items.',
        'objective' => 'Extend the brand identity into physical touchpoints that feel considered, premium and unmistakably consistent.',
        'approach' => 'A compact print system with clear hierarchy, generous spacing and print-safe colour values so every item matches the digital brand.',
        'tags' => ['Stationery', 'Brochures', 'Print Production'],
        'meta_tags' => ['Print', 'Stationery'],
    ],
    [
        'title' => 'Video Content Concept',
        'category' => 'multimedia', 'label' => 'Multimedia', 'is_wide' => 0,
        'preview' => 'video',
        'overlay' => 'Short, well-paced storytelling with clean motion graphics.',
        'summary' => 'A promotional video concept featuring motion graphics, visual storytelling and professional editing.',
        'description' => 'A promotional video concept featuring motion graphics, visual storytelling, and professional editing.',
        'objective' => 'Explain a service clearly and quickly using a short, well-paced promotional video concept.',
        'approach' => 'A tight script, clean motion graphics and a consistent visual language that can be reused across social and web channels.',
        'tags' => ['Video Editing', 'Motion Graphics', 'Storyboarding'],
        'meta_tags' => ['Video', 'Motion'],
    ],
    [
        'title' => 'E-commerce Concept',
        'category' => 'web', 'label' => 'Web Design', 'is_wide' => 1,
        'preview' => 'shop',
        'overlay' => 'A calm product grid that keeps browsing and buying simple.',
        'summary' => 'An e-commerce website concept focusing on product presentation, user experience and conversion-friendly structure.',
        'description' => 'An e-commerce website concept focusing on product presentation, user experience, and conversion optimization.',
        'objective' => 'Present products clearly and reduce friction between browsing and checkout.',
        'approach' => 'A consistent product grid, strong imagery ratios and a simple browsing path supported by clear category structure.',
        'tags' => ['E-commerce', 'Product Grid', 'UX Structure'],
        'meta_tags' => ['E-commerce', 'UX'],
    ],
    [
        'title' => 'Event & Campaign Concept',
        'category' => 'other', 'label' => 'Other Creative Work', 'is_wide' => 0,
        'preview' => 'banner',
        'overlay' => 'One campaign look, reused consistently across every surface.',
        'summary' => 'A visual concept for an event and campaign rollout, including posters, digital banners and promotional items.',
        'description' => 'A creative campaign concept covering event visuals, digital banners, and promotional print materials.',
        'objective' => 'Give a single campaign one recognisable look that works consistently across screens and printed surfaces.',
        'approach' => 'A reusable layout system with a small set of strong visual rules, so new pieces can be produced quickly without losing consistency.',
        'tags' => ['Campaign Design', 'Banners', 'Promotional Print'],
        'meta_tags' => ['Campaign', 'Print'],
    ],
];

$slugify = static function (string $text): string {
    return trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower($text)), '-');
};

// ---- services ----
if ((int) $pdo->query('SELECT COUNT(*) FROM services')->fetchColumn() === 0) {
    $stmt = $pdo->prepare(
        'INSERT INTO services (slug, title, category, icon, summary, features, sort_order, is_published)
         VALUES (:slug, :title, :category, :icon, :summary, :features, :sort_order, 1)'
    );

    foreach ($services as $i => $service) {
        $stmt->execute([
            'slug'       => $slugify($service['title']),
            'title'      => $service['title'],
            'category'   => $service['category'],
            'icon'       => $service['icon'],
            'summary'    => $service['summary'],
            'features'   => json_encode($service['features'], JSON_UNESCAPED_UNICODE),
            'sort_order' => $i + 1,
        ]);
    }

    echo 'Seeded ' . count($services) . " services.\n";
} else {
    echo "Services already populated - skipped.\n";
}

// ---- projects ----
if ((int) $pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn() === 0) {
    $stmt = $pdo->prepare(
        'INSERT INTO projects
            (slug, title, category, label, summary, description, objective, approach, tags, meta_tags, preview, overlay, is_wide, sort_order, is_published)
         VALUES
            (:slug, :title, :category, :label, :summary, :description, :objective, :approach, :tags, :meta_tags, :preview, :overlay, :is_wide, :sort_order, 1)'
    );

    foreach ($projects as $i => $project) {
        $stmt->execute([
            'slug'        => $slugify($project['title']),
            'title'       => $project['title'],
            'category'    => $project['category'],
            'label'       => $project['label'],
            'summary'     => $project['summary'],
            'description' => $project['description'],
            'objective'   => $project['objective'],
            'approach'    => $project['approach'],
            'tags'        => json_encode($project['tags'], JSON_UNESCAPED_UNICODE),
            'meta_tags'   => json_encode($project['meta_tags'], JSON_UNESCAPED_UNICODE),
            'preview'     => $project['preview'],
            'overlay'     => $project['overlay'],
            'is_wide'     => $project['is_wide'],
            'sort_order'  => $i + 1,
        ]);
    }

    echo 'Seeded ' . count($projects) . " portfolio projects.\n";
} else {
    echo "Projects already populated - skipped.\n";
}

echo "Seeding complete.\n";
