<?php
$page_title = 'Gallery';
$page_desc = 'Explore our portfolio of luxury events, exquisite plating, and unforgettable moments captured through the lens.';
$base_path = '';
include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <span class="eyebrow">Visual Journey</span>
            <h1>Our Gallery</h1>
            <p>A curated collection of moments from the extraordinary events we have had the privilege to cater.</p>
            <div class="breadcrumb-nav">
                <a href="index.php">Home</a>
                <span>/</span>
                <span class="current">Gallery</span>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="bg-cream" style="padding: 100px 0;">
    <div class="container">
        <div class="gallery-full-grid" data-aos="fade-up">
            <?php foreach ($gallery_data as $index => $item): ?>
            <div class="gallery-full-item<?php echo $index % 2 === 0 && $index < 2 ? ' tall' : ''; ?>">
                <img src="<?php echo htmlspecialchars($item['src'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['title'] ?? 'Gallery item', ENT_QUOTES, 'UTF-8'); ?>">
                <div class="gallery-full-overlay">
                    <h4><?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h4>
                    <span><?php echo htmlspecialchars($item['location'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
