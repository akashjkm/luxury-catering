<?php
$page_title = 'About Us';
$page_desc = 'Discover the story behind Gourmet Affair — two decades of culinary excellence, passion, and unforgettable dining experiences.';
$base_path = '';
include 'includes/header.php';

$about_content = $site_content['about_page'] ?? [];
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <span class="eyebrow">Who We Are</span>
            <h1>What Makes Us Special</h1>
            <p>A legacy built on passion, precision, and an unwavering commitment to culinary excellence that has defined luxury catering for over two decades.</p>
            <div class="breadcrumb-nav">
                <a href="index.php">Home</a>
                <span>/</span>
                <span class="current">About Us</span>
            </div>
        </div>
    </div>
</section>

<!-- About Story -->
<section class="about-section" style="padding-top: 100px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-images" data-aos="fade-right">
                    <img src="<?php echo htmlspecialchars($about_content['story_img_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="Our kitchen team" class="about-img-main">
                    <img src="<?php echo htmlspecialchars($about_content['story_img_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="Chef plating" class="about-img-secondary">
                </div>
                
            </div>
            <div class="col-lg-6">
                <div class="about-content" data-aos="fade-left">
                    <span class="eyebrow">Our Heritage</span>
                    <h2 class="section-title"><?php echo htmlspecialchars($about_content['story_title'] ?? 'A Journey of Passion & Precision', ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo htmlspecialchars($about_content['story_text_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><?php echo htmlspecialchars($about_content['story_text_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><?php echo htmlspecialchars($about_content['story_text_3'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <a href="contact.php" class="btn btn-gold mt-3">Work With Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="about-values">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="eyebrow">Our Philosophy</span>
            <h2 class="section-title" style="color: var(--color-white);">The Pillars of Excellence</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.5); margin-left: auto; margin-right: auto;">These core values guide every decision we make, from ingredient selection to the final garnish on your plate.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-heart-fill"></i></div>
                    <h3>Passion</h3>
                    <p>Every dish we create is infused with genuine love for the craft. Passion is the secret ingredient that elevates good food to the extraordinary.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-gem"></i></div>
                    <h3>Excellence</h3>
                    <p>We refuse to compromise on quality. From the sourcing of ingredients to the presentation on the plate, only the absolute best will do.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-lightbulb"></i></div>
                    <h3>Innovation</h3>
                    <p>While we honor classical techniques, we constantly push boundaries. Our chefs blend tradition with avant-garde creativity.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-people"></i></div>
                    <h3>Integrity</h3>
                    <p>We build lasting relationships through transparency, honesty, and delivering on every promise we make to our clients.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="about-team">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="eyebrow">The Minds Behind</span>
            <h2 class="section-title">Our Culinary Leaders</h2>
            <p class="section-subtitle" style="margin-left: auto; margin-right: auto;">Meet the extraordinary talents who bring our vision to life, one plate at a time.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1583394293214-28ez8ac94e4a?w=400" alt="Marcus Whitfield" class="team-img">
                    </div>
                    <h4 class="team-name">Marcus Whitfield</h4>
                    <p class="team-role">Executive Chef & Founder</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1581299894007-aaa50297bb16?w=400" alt="Elena Vasquez" class="team-img">
                    </div>
                    <h4 class="team-name">Elena Vasquez</h4>
                    <p class="team-role">Head of Culinary Innovation</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?w=400" alt="David Chen" class="team-img">
                    </div>
                    <h4 class="team-name">David Chen</h4>
                    <p class="team-role">Executive Sous Chef</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?w=400" alt="Sophie Laurent" class="team-img">
                    </div>
                    <h4 class="team-name">Sophie Laurent</h4>
                    <p class="team-role">Head Sommelier</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
