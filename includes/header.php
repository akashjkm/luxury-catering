<?php
require_once __DIR__ . '/../admin/config.php';

// Get current page for active nav highlighting
$current_page = basename($_SERVER['PHP_SELF'], '.php');
if (strpos($_SERVER['PHP_SELF'], '/services/') !== false) {
    $current_page = 'services';
}

$site_settings = readData('settings');
if (!is_array($site_settings)) {
    $site_settings = [];
}

$site_content = readData('content');
if (!is_array($site_content)) {
    $site_content = [];
}

$menu_data = readData('menu');
if (!is_array($menu_data)) {
    $menu_data = [];
}

$testimonials_data = readData('testimonials');
if (!is_array($testimonials_data)) {
    $testimonials_data = [];
}

$gallery_data = readData('gallery');
if (!is_array($gallery_data)) {
    $gallery_data = [];
}

$instagram_videos_data = readData('instagram_videos');
if (!is_array($instagram_videos_data)) {
    $instagram_videos_data = [];
}

$site_name = $site_settings['site_name'] ?? 'Gourmet Affair';
$site_address = $site_settings['address'] ?? '';
$site_phone1 = $site_settings['phone1'] ?? '';
$site_phone2 = $site_settings['phone2'] ?? '';
$site_email = $site_settings['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?><?php echo htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8'); ?> — Luxury Catering</title>
    <meta name="description" content="<?php echo isset($page_desc) ? $page_desc : 'Premium luxury catering for weddings, corporate events, private parties, and celebrity gatherings. Exquisite cuisine, impeccable service.'; ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/style.css">
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="top-bar-text"><i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($site_address, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="col-md-6 text-md-end">
                <?php if (!empty($site_phone1) || !empty($site_phone2)) : ?>
                    <span class="top-bar-text"><i class="bi bi-telephone-fill"></i> <?php echo htmlspecialchars(!empty($site_phone1) ? $site_phone1 : $site_phone2, ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
                <?php if (!empty($site_email)) : ?>
                    <span class="top-bar-text ms-3"><i class="bi bi-envelope-fill"></i> <?php echo htmlspecialchars($site_email, ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $base_path; ?>index.php">
            <span class="brand-text"><?php echo htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8'); ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'index' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'about' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'menu' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>menu.php">Menu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo $current_page == 'services' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>services.php" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Services
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services/private-luxury-events.php">Private Luxury Events</a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services/corporate-catering.php">Corporate Catering</a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services/destination-wedding-catering.php">Destination Wedding Catering</a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services/celebrity-events.php">Celebrity Events</a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services/themed-concept-catering.php">Themed Concept Catering</a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services/sports-family-day-events.php">Sports & Family Day Events</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'blogs' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>blogs.php">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'gallery' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>gallery.php">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'contact' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>contact.php">Contact</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a href="#" class="btn btn-gold btn-sm" data-bs-toggle="modal" data-bs-target="#enquiryModal">Plan Your Event</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
