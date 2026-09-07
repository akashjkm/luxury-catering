<?php
require_once dirname(__FILE__) . '/../config.php';
requireLogin();

$flash = getFlash();
$current_page = basename($_SERVER['PHP_SELF'], '.php');

$unread_inquiries = 0;
if (isDbConnected()) {
    $row = dbFetchOne("SELECT COUNT(*) AS cnt FROM inquiries WHERE status = 'new'");
    $unread_inquiries = (int)($row['cnt'] ?? 0);
}

$nav_items = [
    'dashboard' => ['icon' => 'bi-speedometer2', 'label' => 'Dashboard'],
    'inquiries' => ['icon' => 'bi-envelope', 'label' => 'Inquiries', 'badge' => $unread_inquiries],
    'images' => ['icon' => 'bi-images', 'label' => 'Images'],
    'content' => ['icon' => 'bi-file-text', 'label' => 'Content'],
    'contact-info' => ['icon' => 'bi-telephone', 'label' => 'Contact Info'],
    'menu-manager' => ['icon' => 'bi-menu-button-wide', 'label' => 'Menu'],
    'testimonials' => ['icon' => 'bi-chat-quote', 'label' => 'Testimonials'],
    'gallery-manager' => ['icon' => 'bi-grid-3x3', 'label' => 'Gallery'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin'; ?> | Gourmet Affair</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<!-- Sidebar -->
<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <span class="brand-text">Gourmet<span class="brand-accent">Affair</span></span>
        <small>Admin Panel</small>
    </div>

    <nav class="sidebar-nav">
        <?php foreach ($nav_items as $key => $item): ?>
        <a href="<?php echo $key; ?>.php" class="sidebar-link <?php echo $current_page === $key ? 'active' : ''; ?> d-flex align-items-center">
            <i class="bi <?php echo $item['icon']; ?>"></i>
            <span><?php echo $item['label']; ?></span>
            <?php if (!empty($item['badge']) && $item['badge'] > 0): ?>
            <span class="badge bg-danger ms-auto rounded-pill" style="font-size: 0.72rem; padding: 4px 8px;"><?php echo $item['badge']; ?></span>
            <?php endif; ?>
        </a>
        <?php endforeach; ?>
    </nav>

    <div class="sidebar-footer">
        <a href="logout.php" class="sidebar-link logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>

<!-- Main Content -->
<div class="admin-main">
    <!-- Topbar -->
    <header class="admin-topbar">
        <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <div class="topbar-right">
            <span class="admin-user"><i class="bi bi-person-circle"></i> Administrator</span>
        </div>
    </header>

    <!-- Flash Messages -->
    <?php if ($flash): ?>
    <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show m-4" role="alert">
        <?php echo $flash['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Page Content -->
    <main class="admin-content">
