<?php
$page_title = 'Contact Information';
require_once 'includes/admin-header.php';

$settings = readData('settings');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings['site_name'] = $_POST['site_name'] ?? '';
    $settings['phone1'] = $_POST['phone1'] ?? '';
    $settings['phone2'] = $_POST['phone2'] ?? '';
    $settings['email'] = $_POST['email'] ?? '';
    $settings['address'] = $_POST['address'] ?? '';
    $settings['working_hours'] = $_POST['working_hours'] ?? '';
    $settings['facebook'] = $_POST['facebook'] ?? '';
    $settings['instagram'] = $_POST['instagram'] ?? '';
    $settings['twitter'] = $_POST['twitter'] ?? '';
    $settings['linkedin'] = $_POST['linkedin'] ?? '';
    $settings['pinterest'] = $_POST['pinterest'] ?? '';

    writeData('settings', $settings);
    setFlash('success', 'Contact information updated successfully!');
    header('Location: contact-info.php');
    exit;
}
?>

<h1 class="page-title">Contact Information</h1>
<p class="page-subtitle">Update your business contact details, address, and social media links.</p>

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5>Business Details</h5>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Site Name</label>
                            <input type="text" name="site_name" class="form-control" value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Primary Phone</label>
                            <input type="text" name="phone1" class="form-control" value="<?php echo htmlspecialchars($settings['phone1'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Secondary Phone</label>
                            <input type="text" name="phone2" class="form-control" value="<?php echo htmlspecialchars($settings['phone2'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($settings['email'] ?? ''); ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"><?php echo htmlspecialchars($settings['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Working Hours</label>
                            <textarea name="working_hours" class="form-control" rows="2"><?php echo htmlspecialchars($settings['working_hours'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <hr style="border-color: rgba(255,255,255,0.05); margin: 30px 0;">

                    <h6 style="color: var(--gold); margin-bottom: 20px;">Social Media Links</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Facebook</label>
                            <input type="url" name="facebook" class="form-control" value="<?php echo htmlspecialchars($settings['facebook'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Instagram</label>
                            <input type="url" name="instagram" class="form-control" value="<?php echo htmlspecialchars($settings['instagram'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Twitter / X</label>
                            <input type="url" name="twitter" class="form-control" value="<?php echo htmlspecialchars($settings['twitter'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($settings['linkedin'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pinterest</label>
                            <input type="url" name="pinterest" class="form-control" value="<?php echo htmlspecialchars($settings['pinterest'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-admin">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5>Preview</h5>
            </div>
            <div class="admin-card-body">
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem;">PHONE</span>
                    <p class="mb-0" style="color: #fff;"><?php echo $settings['phone1'] ?? '-'; ?></p>
                </div>
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem;">EMAIL</span>
                    <p class="mb-0" style="color: #fff;"><?php echo $settings['email'] ?? '-'; ?></p>
                </div>
                <div class="mb-3">
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem;">ADDRESS</span>
                    <p class="mb-0" style="color: rgba(255,255,255,0.7); font-size: 0.85rem;"><?php echo nl2br($settings['address'] ?? '-'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
