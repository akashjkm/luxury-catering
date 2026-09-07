<?php
$page_title = 'Luxury Gourmet Catering';
$page_desc = 'Premium luxury catering for weddings, corporate events, private parties, and celebrity gatherings. Exquisite cuisine, impeccable service.';
$base_path = '';
include 'includes/header.php';

$home_content = $site_content['home'] ?? [];
$hero_slides = [
    [
        'eyebrow' => $home_content['hero_slide_1_eyebrow'] ?? 'Since 1998',
        'title' => $home_content['hero_slide_1_title'] ?? 'Culinary Artistry for Discerning Palates',
        'subtitle' => $home_content['hero_slide_1_subtitle'] ?? '',
        'bg' => $home_content['hero_slide_1_bg'] ?? '',
        'btn1' => ['label' => 'Explore Services', 'href' => 'services.php'],
        'btn2' => ['label' => 'Get in Touch', 'href' => 'contact.php']
    ],
    [
        'eyebrow' => $home_content['hero_slide_2_eyebrow'] ?? 'Award-Winning Cuisine',
        'title' => $home_content['hero_slide_2_title'] ?? 'Where Every Bite is a Masterpiece',
        'subtitle' => $home_content['hero_slide_2_subtitle'] ?? '',
        'bg' => $home_content['hero_slide_2_bg'] ?? '',
        'btn1' => ['label' => 'View Our Menu', 'href' => 'menu.php'],
        'btn2' => ['label' => 'Book a Tasting', 'href' => '#', 'modal' => true]
    ],
    [
        'eyebrow' => $home_content['hero_slide_3_eyebrow'] ?? 'White-Glove Service',
        'title' => $home_content['hero_slide_3_title'] ?? 'Creating Memories That Last Forever',
        'subtitle' => $home_content['hero_slide_3_subtitle'] ?? '',
        'bg' => $home_content['hero_slide_3_bg'] ?? '',
        'btn1' => ['label' => 'View Gallery', 'href' => 'gallery.php'],
        'btn2' => ['label' => 'Our Story', 'href' => 'about.php']
    ]
];
$gallery_preview_items = array_slice($gallery_data, 0, 5);
$testimonial_items = $testimonials_data;
$instagram_videos = array_slice($instagram_videos_data, 0, 6);
?>

<!-- Hero Slider -->
<section class="hero-slider">
    <?php foreach ($hero_slides as $index => $slide): ?>
    <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
        <div class="hero-slide-bg" style="background-image: url('<?php echo htmlspecialchars($slide['bg'], ENT_QUOTES, 'UTF-8'); ?>');"></div>
        <div class="hero-slide-overlay"></div>
        <div class="hero-content">
            <span class="hero-eyebrow"><?php echo htmlspecialchars($slide['eyebrow'], ENT_QUOTES, 'UTF-8'); ?></span>
            <h1 class="hero-title"><?php echo nl2br(htmlspecialchars($slide['title'], ENT_QUOTES, 'UTF-8')); ?></h1>
            <p class="hero-subtitle"><?php echo htmlspecialchars($slide['subtitle'], ENT_QUOTES, 'UTF-8'); ?></p>
            <div class="hero-btn">
                <a href="<?php echo htmlspecialchars($slide['btn1']['href'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-gold btn-lg me-3"><?php echo htmlspecialchars($slide['btn1']['label'], ENT_QUOTES, 'UTF-8'); ?></a>
                <a href="<?php echo htmlspecialchars($slide['btn2']['href'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-light btn-lg"<?php echo !empty($slide['btn2']['modal']) ? ' data-bs-toggle="modal" data-bs-target="#enquiryModal"' : ''; ?>><?php echo htmlspecialchars($slide['btn2']['label'], ENT_QUOTES, 'UTF-8'); ?></a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Navigation -->
    <div class="hero-nav">
        <button class="hero-arrow prev" aria-label="Previous slide"><i class="bi bi-chevron-left"></i></button>
        <div class="hero-dots">
            <?php foreach ($hero_slides as $index => $slide): ?>
            <button class="hero-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
        <button class="hero-arrow next" aria-label="Next slide"><i class="bi bi-chevron-right"></i></button>
    </div>

    <!-- Scroll Indicator -->
    <div class="hero-scroll">
        <span class="hero-scroll-text">Scroll</span>
        <div class="hero-scroll-line"></div>
    </div>
</section>

<!-- Signature Services Carousel -->
<section class="services-carousel-section">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="eyebrow">What We Offer</span>
            <h2 class="section-title" style="color: var(--color-white);">Signature Services</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.5); margin-left: auto; margin-right: auto;">Tailored culinary experiences designed to elevate every occasion to the extraordinary.</p>
        </div>

        <div class="services-carousel owl-carousel" data-aos="fade-up" data-aos-delay="200">
            <!-- Service 01 -->
            <div class="service-card">
                <div class="service-number">01</div>
                <div class="service-icon"><i class="bi bi-gem"></i></div>
                <h3>Private Luxury Events</h3>
                <p class="service-tagline">Intimate & Exclusive</p>
                <p class="service-desc">Bespoke dining experiences for the most exclusive gatherings. From intimate chef's table dinners to lavish private celebrations, every detail is meticulously curated.</p>
                <a href="services/private-luxury-events.php" class="service-link">Read More <i class="bi bi-arrow-right"></i></a>
            </div>

            <!-- Service 02 -->
            <div class="service-card">
                <div class="service-number">02</div>
                <div class="service-icon"><i class="bi bi-briefcase"></i></div>
                <h3>Corporate Catering</h3>
                <p class="service-tagline">Professional Excellence</p>
                <p class="service-desc">Elevate your corporate events with sophisticated cuisine that impresses stakeholders and clients alike. Boardroom lunches to gala dinners, delivered flawlessly.</p>
                <a href="services/corporate-catering.php" class="service-link">Read More <i class="bi bi-arrow-right"></i></a>
            </div>

            <!-- Service 03 -->
            <div class="service-card">
                <div class="service-number">03</div>
                <div class="service-icon"><i class="bi bi-heart"></i></div>
                <h3>Destination Weddings</h3>
                <p class="service-tagline">Romance & Elegance</p>
                <p class="service-desc">Create the wedding of your dreams with our destination wedding catering. From vineyard ceremonies to beachfront receptions, we bring culinary magic worldwide.</p>
                <a href="services/destination-wedding-catering.php" class="service-link">Read More <i class="bi bi-arrow-right"></i></a>
            </div>

            <!-- Service 04 -->
            <div class="service-card">
                <div class="service-number">04</div>
                <div class="service-icon"><i class="bi bi-stars"></i></div>
                <h3>Celebrity Events</h3>
                <p class="service-tagline">Discretion & Prestige</p>
                <p class="service-desc">Trusted by A-list celebrities and high-profile personalities for exclusive events. Absolute discretion paired with world-class cuisine and service.</p>
                <a href="services/celebrity-events.php" class="service-link">Read More <i class="bi bi-arrow-right"></i></a>
            </div>

            <!-- Service 05 -->
            <div class="service-card">
                <div class="service-number">05</div>
                <div class="service-icon"><i class="bi bi-palette"></i></div>
                <h3>Themed Concept Catering</h3>
                <p class="service-tagline">Immersive Experiences</p>
                <p class="service-desc">Transform your venue into an immersive world. From Great Gatsby soirées to Mediterranean feasts, we design complete sensory experiences.</p>
                <a href="services/themed-concept-catering.php" class="service-link">Read More <i class="bi bi-arrow-right"></i></a>
            </div>

            <!-- Service 06 -->
            <div class="service-card">
                <div class="service-number">06</div>
                <div class="service-icon"><i class="bi bi-people-fill"></i></div>
                <h3>Sports & Family Day Events</h3>
                <p class="service-tagline">Joyful Celebrations</p>
                <p class="service-desc">Premium catering for sports events, family days, and community gatherings. Delicious food that brings people together in celebration.</p>
                <a href="services/sports-family-day-events.php" class="service-link">Read More <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>

        <div class="owl-nav-custom">
            <button class="services-prev" aria-label="Previous"><i class="bi bi-chevron-left"></i></button>
            <button class="services-next" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- About / Intro Split Section -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-images" data-aos="fade-right">
                    <img src="<?php echo htmlspecialchars($home_content['about_img_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="Chef preparing gourmet dish" class="about-img-main">
                    <img src="<?php echo htmlspecialchars($home_content['about_img_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="Fine dining plating" class="about-img-secondary">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content" data-aos="fade-left">
                    <span class="eyebrow"><?php echo htmlspecialchars($home_content['about_eyebrow'] ?? 'Our Story', ENT_QUOTES, 'UTF-8'); ?></span>
                    <h2 class="section-title"><?php echo htmlspecialchars($home_content['about_title'] ?? 'A Legacy of Culinary Excellence', ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo htmlspecialchars($home_content['about_text_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><?php echo htmlspecialchars($home_content['about_text_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><?php echo htmlspecialchars($home_content['about_text_3'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <a href="about.php" class="btn btn-gold mt-3">Discover Our Story</a>

                    <div class="about-signature">
                        <div>
                            <span class="about-signature-text">— Chef Marcus Whitfield</span>
                            <span style="display: block; font-size: 0.8rem; color: var(--color-text-muted); margin-top: 4px;">Executive Chef & Founder</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Selector Section -->
<section class="menu-section">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="eyebrow">Our Cuisine</span>
            <h2 class="section-title" style="color: var(--color-white);">Curated Menu Collections</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.5); margin-left: auto; margin-right: auto;">Explore our diverse culinary portfolios, each crafted to transport your guests on an unforgettable gastronomic voyage.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="menu-card">
                    <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=600" alt="Contemporary European" class="menu-card-img">
                    <div class="menu-card-overlay"></div>
                    <div class="menu-card-content">
                        <span class="menu-card-label">Signature Collection</span>
                        <h3 class="menu-card-title">Contemporary European</h3>
                        <a href="menu.php" class="btn btn-outline-light btn-sm">Explore Menu</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="menu-card">
                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600" alt="Pan-Asian Fusion" class="menu-card-img">
                    <div class="menu-card-overlay"></div>
                    <div class="menu-card-content">
                        <span class="menu-card-label">Chef's Special</span>
                        <h3 class="menu-card-title">Pan-Asian Fusion</h3>
                        <a href="menu.php" class="btn btn-outline-light btn-sm">Explore Menu</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="menu-card">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600" alt="Farm-to-Table" class="menu-card-img">
                    <div class="menu-card-overlay"></div>
                    <div class="menu-card-content">
                        <span class="menu-card-label">Seasonal Selection</span>
                        <h3 class="menu-card-title">Farm-to-Table</h3>
                        <a href="menu.php" class="btn btn-outline-light btn-sm">Explore Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quality / Ingredients Section -->
<section class="quality-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="quality-images" data-aos="fade-right">
                    <img src="<?php echo htmlspecialchars($home_content['quality_img'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="Fresh ingredients" class="quality-img-main">
                    <div class="quality-badge">
                        <span class="quality-badge-number" data-count="<?php echo htmlspecialchars($home_content['quality_badge_number'] ?? '25', ENT_QUOTES, 'UTF-8'); ?>" data-suffix="+">0</span>
                        <span class="quality-badge-text"><?php echo htmlspecialchars($home_content['quality_badge_text'] ?? 'Years of Excellence', ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="quality-content" data-aos="fade-left">
                    <span class="eyebrow">Our Standards</span>
                    <h2 class="section-title"><?php echo htmlspecialchars($home_content['quality_title'] ?? 'Only the Finest Ingredients', ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo htmlspecialchars($home_content['quality_text_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><?php echo htmlspecialchars($home_content['quality_text_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

                    <div class="quality-features">
                        <div class="quality-feature">
                            <div class="quality-feature-icon"><i class="bi bi-leaf"></i></div>
                            <div>
                                <h4>Sustainably Sourced</h4>
                                <p>100% traceable, ethically sourced ingredients from certified suppliers.</p>
                            </div>
                        </div>
                        <div class="quality-feature">
                            <div class="quality-feature-icon"><i class="bi bi-award"></i></div>
                            <div>
                                <h4>Artisan Partnerships</h4>
                                <p>Direct relationships with award-winning producers and small-batch artisans.</p>
                            </div>
                        </div>
                        <div class="quality-feature">
                            <div class="quality-feature-icon"><i class="bi bi-shield-check"></i></div>
                            <div>
                                <h4>Certified Quality</h4>
                                <p>ISO 22000 certified with rigorous HACCP protocols at every stage.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio / Gallery Preview -->
<section class="gallery-preview-section">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="eyebrow">Our Work</span>
            <h2 class="section-title" style="color: var(--color-white);">Moments We Have Crafted</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.5); margin-left: auto; margin-right: auto;">A glimpse into the extraordinary events we have had the privilege to cater.</p>
        </div>

        <div class="gallery-grid" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($gallery_preview_items as $index => $item): ?>
            <div class="gallery-item">
                <img src="<?php echo htmlspecialchars($item['src'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['title'] ?? 'Gallery item', ENT_QUOTES, 'UTF-8'); ?>">
                <div class="gallery-item-overlay">
                    <div class="gallery-item-icon"><i class="bi bi-zoom-in"></i></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="gallery.php" class="btn btn-outline-gold">View Full Gallery</a>
        </div>
    </div>
</section>

<!-- Testimonials Carousel -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="eyebrow">Client Voices</span>
            <h2 class="section-title">Words of Appreciation</h2>
            <p class="section-subtitle" style="margin-left: auto; margin-right: auto;">Hear from the distinguished hosts who have entrusted us with their most important occasions.</p>
        </div>

        <div class="testimonials-carousel owl-carousel" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($testimonial_items as $index => $testimonial): ?>
            <div class="testimonial-item">
                <img src="<?php echo htmlspecialchars($testimonial['photo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($testimonial['name'] ?? 'Testimonial', ENT_QUOTES, 'UTF-8'); ?>" class="testimonial-photo">
                <p class="testimonial-quote"><?php echo htmlspecialchars($testimonial['quote'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                <h4 class="testimonial-name"><?php echo htmlspecialchars($testimonial['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h4>
                <p class="testimonial-company"><?php echo htmlspecialchars($testimonial['company'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="testimonial-pagination">
            <?php foreach ($testimonial_items as $index => $testimonial): ?>
            <button class="testimonial-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></button>
            <?php endforeach; ?>
        </div>

        <div class="testimonial-arrows">
            <button class="testimonial-arrow prev" aria-label="Previous testimonial"><i class="bi bi-chevron-left"></i></button>
            <button class="testimonial-arrow next" aria-label="Next testimonial"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- Instagram Videos -->
<section class="instagram-section">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="eyebrow">From Our Kitchen</span>
            <h2 class="section-title">Latest on Instagram</h2>
            <p class="section-subtitle" style="margin-left: auto; margin-right: auto;">A closer look at the flavours, celebrations, and details behind our latest events.</p>
        </div>

        <?php if (!empty($instagram_videos)): ?>
        <div class="instagram-grid" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($instagram_videos as $video): ?>
            <?php $permalink = $video['url'] ?? ''; ?>
            <?php if ($permalink !== ''): ?>
            <div class="instagram-video-card">
                <blockquote class="instagram-media" data-instgrm-permalink="<?php echo htmlspecialchars($permalink, ENT_QUOTES, 'UTF-8'); ?>" data-instgrm-version="14">
                    <a href="<?php echo htmlspecialchars($permalink, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">View this post on Instagram</a>
                </blockquote>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <script async src="https://www.instagram.com/embed.js"></script>
        <?php endif; ?>

        <?php if (!empty($site_settings['instagram'] ?? '')): ?>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?php echo htmlspecialchars($site_settings['instagram'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-gold" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram me-2"></i>Follow Our Journey</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Venues Section -->
<section class="venues-section">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="eyebrow">Partner Venues</span>
            <h2 class="section-title" style="color: var(--color-white);">Prestigious Locations</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.5); margin-left: auto; margin-right: auto;">We are proud to be the preferred catering partner at some of the world's most iconic venues.</p>
        </div>

        <div class="venues-carousel owl-carousel" data-aos="fade-up" data-aos-delay="200">
            <div class="venue-card">
                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=600" alt="The Plaza Ballroom" class="venue-card-img">
                <div class="venue-card-overlay">
                    <h4 class="venue-card-name">The Plaza Ballroom</h4>
                    <p class="venue-card-location">New York, USA</p>
                </div>
            </div>

            <div class="venue-card">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600" alt="Château de Versailles" class="venue-card-img">
                <div class="venue-card-overlay">
                    <h4 class="venue-card-name">Château de Versailles</h4>
                    <p class="venue-card-location">Versailles, France</p>
                </div>
            </div>

            <div class="venue-card">
                <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600" alt="The Savoy London" class="venue-card-img">
                <div class="venue-card-overlay">
                    <h4 class="venue-card-name">The Savoy London</h4>
                    <p class="venue-card-location">London, UK</p>
                </div>
            </div>

            <div class="venue-card">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=600" alt="Four Seasons Dubai" class="venue-card-img">
                <div class="venue-card-overlay">
                    <h4 class="venue-card-name">Four Seasons Dubai</h4>
                    <p class="venue-card-location">Dubai, UAE</p>
                </div>
            </div>

            <div class="venue-card">
                <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600" alt="Villa d'Este" class="venue-card-img">
                <div class="venue-card-overlay">
                    <h4 class="venue-card-name">Villa d'Este</h4>
                    <p class="venue-card-location">Lake Como, Italy</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
