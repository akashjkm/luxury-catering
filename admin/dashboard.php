<?php
$page_title = 'Dashboard';
require_once 'includes/admin-header.php';

$settings = readData('settings');
$content = readData('content');
$menu = readData('menu');
$testimonials = readData('testimonials');
$gallery = readData('gallery');

$totalMenuItems = 0;
foreach ($menu as $catItems) {
    if (is_array($catItems)) {
        $totalMenuItems += count($catItems);
    }
}

// Inquiries stats
$totalInquiries = 0;
$newInquiries = 0;
$recentInquiries = [];
$totalSubscribers = 0;

if (isDbConnected()) {
    $row = dbFetchOne("SELECT COUNT(*) as cnt FROM inquiries");
    $totalInquiries = (int)($row['cnt'] ?? 0);

    $rowNew = dbFetchOne("SELECT COUNT(*) as cnt FROM inquiries WHERE status = 'new'");
    $newInquiries = (int)($rowNew['cnt'] ?? 0);

    $recentInquiries = dbFetchAll("SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 5");

    $subRow = dbFetchOne("SELECT COUNT(*) as cnt FROM newsletter_subscribers WHERE status = 'subscribed'");
    $totalSubscribers = (int)($subRow['cnt'] ?? 0);
}

$stats = [
    ['icon' => 'bi-envelope', 'number' => $totalInquiries, 'label' => 'Total Inquiries', 'badge' => ($newInquiries > 0 ? "{$newInquiries} New" : null), 'badge_class' => 'bg-danger', 'link' => 'inquiries.php'],
    ['icon' => 'bi-menu-button-wide', 'number' => $totalMenuItems, 'label' => 'Menu Items', 'link' => 'menu-manager.php'],
    ['icon' => 'bi-images', 'number' => count($gallery), 'label' => 'Gallery Images', 'link' => 'gallery-manager.php'],
    ['icon' => 'bi-chat-quote', 'number' => count($testimonials), 'label' => 'Testimonials', 'link' => 'testimonials.php'],
];
?>

<!-- Top Info Bar -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h1 class="page-title mb-1">Dashboard</h1>
        <p class="page-subtitle mb-0">Overview of website performance, inquiries, and culinary assets.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <?php if (isDbConnected()): ?>
            <span class="badge bg-success d-flex align-items-center gap-1 px-3 py-2" style="font-size: 0.8rem; font-weight: 500;">
                <i class="bi bi-database-check"></i> MySQL Database Connected
            </span>
        <?php else: ?>
            <span class="badge bg-warning text-dark d-flex align-items-center gap-1 px-3 py-2" style="font-size: 0.8rem; font-weight: 500;">
                <i class="bi bi-exclamation-triangle"></i> Fallback JSON Mode
            </span>
        <?php endif; ?>
        <a href="inquiries.php" class="btn btn-sm btn-gold d-flex align-items-center gap-1">
            <i class="bi bi-inbox-fill"></i> View Inquiries
            <?php if ($newInquiries > 0): ?>
                <span class="badge bg-danger ms-1"><?php echo $newInquiries; ?></span>
            <?php endif; ?>
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <?php foreach ($stats as $stat): ?>
    <div class="col-lg-3 col-md-6">
        <a href="<?php echo $stat['link'] ?? '#'; ?>" class="text-decoration-none">
            <div class="stat-card position-relative" data-aos="fade-up">
                <div class="stat-icon"><i class="bi <?php echo $stat['icon']; ?>"></i></div>
                <div>
                    <div class="stat-number d-flex align-items-center gap-2">
                        <?php echo $stat['number']; ?>
                        <?php if (!empty($stat['badge'])): ?>
                            <span class="badge <?php echo $stat['badge_class']; ?>" style="font-size: 0.7rem; font-weight: 600;"><?php echo $stat['badge']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="stat-label"><?php echo $stat['label']; ?></div>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4 mb-4">
    <!-- Recent Inquiries Section -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-inbox me-2" style="color: var(--gold);"></i>Recent Customer Inquiries</h5>
                <a href="inquiries.php" class="btn btn-sm btn-admin-outline" style="font-size: 0.78rem;">View All</a>
            </div>
            <div class="admin-card-body p-0">
                <?php if (empty($recentInquiries)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-envelope-open" style="font-size: 2rem; color: var(--gold); display: block; margin-bottom: 8px;"></i>
                        <p class="mb-0">No customer inquiries recorded yet.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="background-color: transparent; color: #eee;">
                            <thead style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem;">
                                <tr>
                                    <th style="padding: 12px 16px; color: rgba(255,255,255,0.7); background-color: transparent;">Client</th>
                                    <th style="color: rgba(255,255,255,0.7); background-color: transparent;">Event</th>
                                    <th style="color: rgba(255,255,255,0.7); background-color: transparent;">Date</th>
                                    <th style="color: rgba(255,255,255,0.7); background-color: transparent;">Status</th>
                                    <th class="text-end" style="padding-right: 16px; color: rgba(255,255,255,0.7); background-color: transparent;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentInquiries as $inq): ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); background-color: var(--black-soft, #1a1a1a);">
                                    <td style="padding: 12px 16px; background-color: transparent;">
                                        <strong style="color: #fff;"><?php echo htmlspecialchars($inq['name']); ?></strong><br>
                                        <small style="color: rgba(255,255,255,0.5);"><i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($inq['email']); ?></small>
                                    </td>
                                    <td style="background-color: transparent;">
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $inq['event_type'] ?: 'Event'))); ?></span>
                                    </td>
                                    <td style="font-size: 0.85rem; color: rgba(255,255,255,0.6); background-color: transparent;">
                                        <?php echo date('M d, Y', strtotime($inq['created_at'])); ?>
                                    </td>
                                    <td style="background-color: transparent;">
                                        <?php if ($inq['status'] === 'new'): ?>
                                            <span class="badge bg-danger">New</span>
                                        <?php elseif ($inq['status'] === 'contacted'): ?>
                                            <span class="badge bg-warning text-dark">Contacted</span>
                                        <?php else: ?>
                                            <span class="badge bg-dark">Archived</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end" style="padding-right: 16px; background-color: transparent;">
                                        <a href="inquiries.php?filter=all" class="btn btn-sm btn-outline-light">
                                            <i class="bi bi-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Info & Newsletter Stats -->
    <div class="col-lg-4">
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="bi bi-newspaper me-2" style="color: var(--gold);"></i>Culinary Journal</h5>
            </div>
            <div class="admin-card-body">
                <div class="d-flex align-items-center justify-content-between mb-3 p-3" style="background: var(--black-soft); border-radius: 4px;">
                    <div>
                        <div style="color: rgba(255,255,255,0.5); font-size: 0.75rem; text-transform: uppercase;">Active Subscribers</div>
                        <div style="font-size: 1.6rem; font-weight: 700; color: var(--gold);"><?php echo $totalSubscribers; ?></div>
                    </div>
                    <i class="bi bi-people" style="font-size: 2rem; color: rgba(201,169,98,0.5);"></i>
                </div>
                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.5); margin-bottom: 0;">
                    Subscribers who opted in via the footer newsletter form.
                </p>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-info-circle me-2" style="color: var(--gold);"></i>Site Info</h5>
            </div>
            <div class="admin-card-body">
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase;">Site Name</span>
                    <p class="mb-0" style="color: #fff; font-weight: 500;"><?php echo htmlspecialchars($settings['site_name'] ?? 'Gourmet Affair'); ?></p>
                </div>
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase;">Phone</span>
                    <p class="mb-0" style="color: #fff;"><?php echo htmlspecialchars($settings['phone1'] ?? 'N/A'); ?></p>
                </div>
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase;">Email</span>
                    <p class="mb-0" style="color: #fff;"><?php echo htmlspecialchars($settings['email'] ?? 'N/A'); ?></p>
                </div>
                <a href="contact-info.php" class="btn btn-admin-outline btn-sm w-100">Edit Contact Info</a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Row -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="bi bi-lightning-charge me-2" style="color: var(--gold);"></i>Quick Actions</h5>
    </div>
    <div class="admin-card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <a href="inquiries.php" class="text-decoration-none">
                    <div class="p-3 text-center" style="background: var(--black-soft); border: 1px solid rgba(255,255,255,0.05); border-radius: 4px;">
                        <i class="bi bi-envelope-open" style="font-size: 1.8rem; color: var(--gold);"></i>
                        <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.8); font-size: 0.85rem;">Manage Inquiries</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="menu-manager.php" class="text-decoration-none">
                    <div class="p-3 text-center" style="background: var(--black-soft); border: 1px solid rgba(255,255,255,0.05); border-radius: 4px;">
                        <i class="bi bi-menu-button-wide" style="font-size: 1.8rem; color: var(--gold);"></i>
                        <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.8); font-size: 0.85rem;">Manage Menu</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="gallery-manager.php" class="text-decoration-none">
                    <div class="p-3 text-center" style="background: var(--black-soft); border: 1px solid rgba(255,255,255,0.05); border-radius: 4px;">
                        <i class="bi bi-grid-3x3" style="font-size: 1.8rem; color: var(--gold);"></i>
                        <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.8); font-size: 0.85rem;">Manage Gallery</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="content.php" class="text-decoration-none">
                    <div class="p-3 text-center" style="background: var(--black-soft); border: 1px solid rgba(255,255,255,0.05); border-radius: 4px;">
                        <i class="bi bi-file-text" style="font-size: 1.8rem; color: var(--gold);"></i>
                        <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.8); font-size: 0.85rem;">Edit Content</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>