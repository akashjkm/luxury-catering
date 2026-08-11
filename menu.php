<?php
$page_title = 'Our Menu';
$page_desc = 'Explore our curated menu collections — from Contemporary European to Pan-Asian Fusion and Farm-to-Table seasonal selections.';
$base_path = '';
include 'includes/header.php';

$menu_sections = [
    [
        'title' => 'Contemporary European',
        'eyebrow' => 'Signature Collection',
        'subtitle' => 'Modern interpretations of classic European cuisine, elevated with contemporary techniques and the finest seasonal ingredients.',
        'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600',
        'items' => $menu_data['contemporary_european'] ?? []
    ],
    [
        'title' => 'Pan-Asian Fusion',
        'eyebrow' => "Chef's Special",
        'subtitle' => 'A bold marriage of Eastern traditions and Western innovation, creating dishes that surprise and seduce the palate.',
        'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600',
        'items' => $menu_data['pan_asian_fusion'] ?? []
    ],
    [
        'title' => 'Farm-to-Table',
        'eyebrow' => 'Seasonal Selection',
        'subtitle' => 'Celebrating the bounty of the season with ingredients sourced directly from local organic farms and artisan producers.',
        'image' => 'https://images.unsplash.com/photo-1466637574441-749b8f19452f?w=600',
        'items' => $menu_data['farm_to_table'] ?? []
    ]
];
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <span class="eyebrow">Culinary Collections</span>
            <h1>Our Menu</h1>
            <p>Each dish is a carefully composed symphony of flavors, textures, and visual artistry designed to captivate and delight.</p>
            <div class="breadcrumb-nav">
                <a href="index.php">Home</a>
                <span>/</span>
                <span class="current">Menu</span>
            </div>
        </div>
    </div>
</section>

<?php foreach ($menu_sections as $index => $section): ?>
<section class="menu-category-section">
    <div class="container">
        <div class="row align-items-center<?php echo $index === 1 ? ' flex-row-reverse' : ''; ?>">
            <div class="col-lg-5" data-aos="fade-<?php echo $index === 1 ? 'left' : 'right'; ?>">
                <img src="<?php echo htmlspecialchars($section['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8'); ?>" class="menu-category-img">
            </div>
            <div class="col-lg-7 <?php echo $index === 1 ? 'pe-lg-5' : 'ps-lg-5'; ?>" data-aos="fade-<?php echo $index === 1 ? 'right' : 'left'; ?>">
                <span class="eyebrow"><?php echo htmlspecialchars($section['eyebrow'], ENT_QUOTES, 'UTF-8'); ?></span>
                <h2 class="section-title"><?php echo htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                <p class="section-subtitle"><?php echo htmlspecialchars($section['subtitle'], ENT_QUOTES, 'UTF-8'); ?></p>

                <?php foreach ($section['items'] as $item): ?>
                <div class="menu-item">
                    <div>
                        <h4 class="menu-item-name"><?php echo htmlspecialchars($item['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h4>
                        <p class="menu-item-desc"><?php echo htmlspecialchars($item['desc'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <span class="menu-item-price"><?php echo htmlspecialchars($item['price'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endforeach; ?>

<?php include 'includes/footer.php'; ?>
