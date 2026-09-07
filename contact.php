<?php
$page_title = 'Contact Us';
$page_desc = 'Get in touch with Gourmet Affair to plan your next luxury event. Book a tasting, request a proposal, or speak with our team.';
$base_path = '';

$contact_success = '';
$contact_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/includes/db.php';

    $name      = trim($_POST['name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $eventType = trim($_POST['event_type'] ?? '');
    $eventDate = trim($_POST['event_date'] ?? '');
    $venue     = trim($_POST['venue'] ?? '');
    $message   = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($phone)) {
        $contact_error = 'Please fill in all required fields (Name, Email, Phone).';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $contact_error = 'Please provide a valid email address.';
    } else {
        if (isDbConnected()) {
            $sql = "INSERT INTO inquiries (name, email, phone, event_type, event_date, venue, message, source, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'contact_page', 'new')";
            if (dbExecute($sql, [$name, $email, $phone, $eventType, $eventDate, $venue, $message])) {
                $contact_success = "Thank you, " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "! Your enquiry has been received. Our team will contact you within 24 hours.";
            } else {
                $contact_error = 'Unable to save your message. Please try again or call us directly.';
            }
        } else {
            $contact_error = 'Database is currently offline. Please reach out to us by phone directly.';
        }
    }
}

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <span class="eyebrow">Get in Touch</span>
            <h1>Contact Us</h1>
            <p>We would be honored to bring your vision to life. Reach out and let us begin crafting your extraordinary event.</p>
            <div class="breadcrumb-nav">
                <a href="index.php">Home</a>
                <span>/</span>
                <span class="current">Contact</span>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="bg-cream" style="padding: 80px 0 40px;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <h4>Visit Us</h4>
                    <p><?php echo nl2br(htmlspecialchars($site_settings['address'] ?? '', ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
                    <h4>Call Us</h4>
                    <p>
                        <?php $phones = array_values(array_filter([$site_settings['phone1'] ?? '', $site_settings['phone2'] ?? ''], function($value) { return $value !== ''; })); ?>
                        <?php echo implode('<br>', array_map(function($phone) { return htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); }, $phones)); ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
                    <h4>Email Us</h4>
                    <p><?php echo htmlspecialchars($site_settings['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="bi bi-clock-fill"></i></div>
                    <h4>Working Hours</h4>
                    <p><?php echo nl2br(htmlspecialchars($site_settings['working_hours'] ?? '', ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Map -->
<section class="contact-form-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="contact-form-wrapper">
                    <span class="eyebrow">Send a Message</span>
                    <h2 class="section-title">Let's Plan Your Event</h2>
                    <p class="mb-4" style="color: var(--color-text-light);">Fill out the form below and our team will respond within 24 hours with a bespoke proposal tailored to your event.</p>

                    <?php if (!empty($contact_success)): ?>
                    <div class="alert mb-4" style="background: rgba(201, 169, 98, 0.15); border: 1px solid var(--color-gold); color: #fff; padding: 16px 20px; border-radius: 4px;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-3" style="color: var(--color-gold); font-size: 1.4rem;"></i>
                            <div><?php echo $contact_success; ?></div>
                        </div>
                    </div>
                    <?php elseif (!empty($contact_error)): ?>
                    <div class="alert mb-4" style="background: rgba(220, 53, 69, 0.15); border: 1px solid #dc3545; color: #ff8585; padding: 16px 20px; border-radius: 4px;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-3" style="color: #dc3545; font-size: 1.4rem;"></i>
                            <div><?php echo htmlspecialchars($contact_error, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Your Full Name *" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Email Address *" required>
                            </div>
                            <div class="col-md-6">
                                <input type="tel" class="form-control" name="phone" placeholder="Phone Number *" required>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" name="event_type" style="appearance: auto; -webkit-appearance: auto; padding: 14px 18px; background: var(--color-cream); border: 1px solid transparent;">
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
                            <div class="col-12">
                                <input type="text" class="form-control" name="event_date" placeholder="Event Date (Approximate)">
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" name="venue" placeholder="Event Venue / Location">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" name="message" rows="5" placeholder="Tell us about your event — guest count, cuisine preferences, special requests..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-gold">Send Enquiry</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5" data-aos="fade-left">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.217676750664!2d-73.98484468459418!3d40.748440979328!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sPark%20Ave%2C%20New%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1699999999999!5m2!1sen!2sin" 
                    class="contact-map" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
