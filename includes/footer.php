<?php
// Footer include
?>

<!-- CTA Banner Section -->
<section class="cta-banner">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8" data-aos="fade-up">
                <span class="eyebrow">Experience Excellence</span>
                <h2 class="cta-title"><?php echo htmlspecialchars($site_content['home']['cta_title'] ?? 'Book a Complimentary Food Tasting Session', ENT_QUOTES, 'UTF-8'); ?></h2>
                <p class="cta-subtitle"><?php echo htmlspecialchars($site_content['home']['cta_subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                <a href="#" class="btn btn-gold btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#enquiryModal">Book Your Tasting</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row g-5">
            <!-- About -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand">
                    <span class="brand-text"><?php echo htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <p class="footer-about">For over two decades, Gourmet Affair has redefined luxury catering across the globe. We blend culinary artistry with white-glove service to create unforgettable dining experiences for the world's most discerning hosts.</p>
                <div class="footer-social">
                    <?php if (!empty($site_settings['facebook'] ?? '')) : ?>
                        <a href="<?php echo htmlspecialchars($site_settings['facebook'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Facebook" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($site_settings['instagram'] ?? '')) : ?>
                        <a href="<?php echo htmlspecialchars($site_settings['instagram'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Instagram" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($site_settings['twitter'] ?? '')) : ?>
                        <a href="<?php echo htmlspecialchars($site_settings['twitter'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Twitter" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter-x"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($site_settings['linkedin'] ?? '')) : ?>
                        <a href="<?php echo htmlspecialchars($site_settings['linkedin'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($site_settings['pinterest'] ?? '')) : ?>
                        <a href="<?php echo htmlspecialchars($site_settings['pinterest'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Pinterest" target="_blank" rel="noopener noreferrer"><i class="bi bi-pinterest"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-title">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo $base_path; ?>index.php">Home</a></li>
                    <li><a href="<?php echo $base_path; ?>about.php">About Us</a></li>
                    <li><a href="<?php echo $base_path; ?>menu.php">Our Menu</a></li>
                    <li><a href="<?php echo $base_path; ?>services.php">Services</a></li>
                    <li><a href="<?php echo $base_path; ?>gallery.php">Gallery</a></li>
                    <li><a href="<?php echo $base_path; ?>blogs.php">Blogs</a></li>
                    <li><a href="<?php echo $base_path; ?>contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-title">Services</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo $base_path; ?>services/private-luxury-events.php">Private Events</a></li>
                    <li><a href="<?php echo $base_path; ?>services/corporate-catering.php">Corporate Catering</a></li>
                    <li><a href="<?php echo $base_path; ?>services/destination-wedding-catering.php">Wedding Catering</a></li>
                    <li><a href="<?php echo $base_path; ?>services/celebrity-events.php">Celebrity Events</a></li>
                    <li><a href="<?php echo $base_path; ?>services/themed-concept-catering.php">Themed Catering</a></li>
                    <li><a href="<?php echo $base_path; ?>services/sports-family-day-events.php">Family Events</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-title">Get in Touch</h5>
                <ul class="footer-contact">
                    <li>
                        <i class="bi bi-geo-alt-fill"></i>
                        <span><?php echo nl2br(htmlspecialchars($site_address, ENT_QUOTES, 'UTF-8')); ?></span>
                    </li>
                    <li>
                        <i class="bi bi-telephone-fill"></i>
                        <span>
                            <?php $phones = array_values(array_filter([$site_settings['phone1'] ?? '', $site_settings['phone2'] ?? ''], function($value) { return $value !== ''; })); ?>
                            <?php echo implode('<br>', array_map(function($phone) { return htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); }, $phones)); ?>
                        </span>
                    </li>
                    <li>
                        <i class="bi bi-envelope-fill"></i>
                        <span><?php echo htmlspecialchars($site_email, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li>
                        <i class="bi bi-clock-fill"></i>
                        <span><?php echo nl2br(htmlspecialchars($site_settings['working_hours'] ?? '', ENT_QUOTES, 'UTF-8')); ?></span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Newsletter -->
        <div class="footer-newsletter">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h5 class="newsletter-title">Subscribe to Our Culinary Journal</h5>
                    <p class="newsletter-text">Receive seasonal menus, event inspiration, and exclusive tasting invitations.</p>
                </div>
                <div class="col-lg-6">
                    <form class="newsletter-form" id="newsletterForm" action="<?php echo $base_path; ?>api/subscribe-newsletter.php" method="POST">
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Your email address" required>
                            <button class="btn btn-gold" type="submit">Subscribe</button>
                        </div>
                        <div id="newsletterFeedback" class="mt-2" style="font-size: 0.85rem; display: none;"></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">&copy; <?php echo date('Y'); ?> Gourmet Affair. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="copyright-links">
                        <a href="#">Privacy Policy</a>
                        <span class="divider">|</span>
                        <a href="#">Terms of Service</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Floating Action Buttons -->
<div class="floating-actions">
    <?php $primary_phone = $site_settings['phone1'] ?? ''; ?>
    <a href="https://wa.me/<?php echo urlencode($primary_phone); ?>" class="float-btn whatsapp" target="_blank" aria-label="WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    <a href="tel:<?php echo htmlspecialchars($primary_phone, ENT_QUOTES, 'UTF-8'); ?>" class="float-btn call" aria-label="Call Us">
        <i class="bi bi-telephone-fill"></i>
    </a>
</div>

<!-- Enquiry Modal -->
<div class="modal fade enquiry-modal" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enquiryModalLabel">Plan Your Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="modal-subtitle">Tell us about your event and our team will craft a bespoke proposal within 24 hours.</p>
                <div id="enquiryAlert" class="alert d-none mb-3"></div>
                <form id="enquiryForm" action="<?php echo $base_path; ?>api/submit-enquiry.php" method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Your Full Name *" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email Address *" required>
                    </div>
                    <div class="mb-3">
                        <input type="tel" class="form-control" name="phone" placeholder="Phone Number *" required>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="event_type">
                            <option value="" selected disabled>Select Event Type</option>
                            <option value="private">Private Luxury Event</option>
                            <option value="corporate">Corporate Catering</option>
                            <option value="wedding">Wedding Catering</option>
                            <option value="celebrity">Celebrity Event</option>
                            <option value="themed">Themed Concept Event</option>
                            <option value="family">Sports / Family Day</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="message" rows="4" placeholder="Tell us about your event — guest count, date, venue, cuisine preferences..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-gold w-100" id="enquirySubmitBtn">Send Enquiry</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?php echo $base_path; ?>js/main.js"></script>
</body>
</html>
