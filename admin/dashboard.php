<?php
$page_title = 'Dashboard';
require_once 'includes/admin-header.php';

$settings = readData('settings');
$content = readData('content');
$menu = readData('menu');
$testimonials = readData('testimonials');
$gallery = readData('gallery');

$stats = [
    ['icon' => 'bi-images', 'number' => count($gallery), 'label' => 'Gallery Images'],
    ['icon' => 'bi-menu-button-wide', 'number' => count($menu['contemporary_european'] ?? []) + count($menu['pan_asian_fusion'] ?? []) + count($menu['farm_to_table'] ?? []), 'label' => 'Menu Items'],
    ['icon' => 'bi-chat-quote', 'number' => count($testimonials), 'label' => 'Testimonials'],
    ['icon' => 'bi-file-text', 'number' => count($content), 'label' => 'Content Sections'],
];
?>

<div class="row g-4 mb-4">
    <?php foreach ($stats as $stat): ?>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" data-aos="fade-up">
            <div class="stat-icon"><i class="bi <?php echo $stat['icon']; ?>"></i></div>
            <div>
                <div class="stat-number"><?php echo $stat['number']; ?></div>
                <div class="stat-label"><?php echo $stat['label']; ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-lightning-charge me-2" style="color: var(--gold);"></i>Quick Actions</h5>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="images.php" class="text-decoration-none">
                            <div class="p-4 text-center" style="background: var(--black-soft); border: 1px solid rgba(255,255,255,0.05);">
                                <i class="bi bi-images" style="font-size: 2rem; color: var(--gold);"></i>
                                <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">Change Images</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="content.php" class="text-decoration-none">
                            <div class="p-4 text-center" style="background: var(--black-soft); border: 1px solid rgba(255,255,255,0.05);">
                                <i class="bi bi-file-text" style="font-size: 2rem; color: var(--gold);"></i>
                                <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">Edit Content</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="contact-info.php" class="text-decoration-none">
                            <div class="p-4 text-center" style="background: var(--black-soft); border: 1px solid rgba(255,255,255,0.05);">
                                <i class="bi bi-telephone" style="font-size: 2rem; color: var(--gold);"></i>
                                <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">Update Contact</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-info-circle me-2" style="color: var(--gold);"></i>Site Info</h5>
            </div>
            <div class="admin-card-body">
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase;">Phone</span>
                    <p class="mb-0" style="color: #fff;"><?php echo $settings['phone1'] ?? 'N/A'; ?></p>
                </div>
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase;">Email</span>
                    <p class="mb-0" style="color: #fff;"><?php echo $settings['email'] ?? 'N/A'; ?></p>
                </div>
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase;">Address</span>
                    <p class="mb-0" style="color: rgba(255,255,255,0.7); font-size: 0.85rem;"><?php echo $settings['address'] ?? 'N/A'; ?></p>
                </div>
                <a href="contact-info.php" class="btn btn-admin-outline btn-sm w-100">Edit Contact Info</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
