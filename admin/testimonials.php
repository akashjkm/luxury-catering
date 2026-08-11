<?php
$page_title = 'Testimonials';
require_once 'includes/admin-header.php';

$testimonials = readData('testimonials');

// Handle delete
if (isset($_GET['delete'])) {
    $idx = (int)$_GET['delete'];
    if (isset($testimonials[$idx])) {
        array_splice($testimonials, $idx, 1);
        writeData('testimonials', $testimonials);
        setFlash('success', 'Testimonial deleted successfully!');
    }
    header('Location: testimonials.php');
    exit;
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idx = $_POST['item_index'] ?? '';
    $item = [
        'name' => $_POST['name'] ?? '',
        'company' => $_POST['company'] ?? '',
        'quote' => $_POST['quote'] ?? '',
        'photo' => $_POST['photo'] ?? ''
    ];

    if ($idx !== '' && isset($testimonials[$idx])) {
        $testimonials[$idx] = $item;
        setFlash('success', 'Testimonial updated successfully!');
    } else {
        $testimonials[] = $item;
        setFlash('success', 'Testimonial added successfully!');
    }
    writeData('testimonials', $testimonials);
    header('Location: testimonials.php');
    exit;
}

$editItem = null;
$editIdx = null;
if (isset($_GET['edit'])) {
    $editIdx = (int)$_GET['edit'];
    $editItem = $testimonials[$editIdx] ?? null;
}
?>

<h1 class="page-title">Testimonials</h1>
<p class="page-subtitle">Manage client testimonials displayed on your homepage.</p>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5>All Testimonials</h5>
            </div>
            <div class="admin-card-body p-0">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Photo</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Quote</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonials as $i => $t): ?>
                        <tr>
                            <td>
                                <?php if (!empty($t['photo'])): ?>
                                <img src="<?php echo $t['photo']; ?>" class="img-thumb" alt="">
                                <?php else: ?>
                                <div class="img-thumb d-flex align-items-center justify-content-center" style="background: var(--black-soft);"><i class="bi bi-person" style="color: rgba(255,255,255,0.2);"></i></div>
                                <?php endif; ?>
                            </td>
                            <td style="color: #fff; font-weight: 500;"><?php echo htmlspecialchars($t['name']); ?></td>
                            <td><?php echo htmlspecialchars($t['company']); ?></td>
                            <td style="max-width: 300px;"><span style="font-size: 0.8rem; color: rgba(255,255,255,0.5);"><?php echo substr(htmlspecialchars($t['quote']), 0, 80); ?>...</span></td>
                            <td>
                                <a href="?edit=<?php echo $i; ?>" class="btn btn-admin-outline btn-sm" style="padding: 5px 12px;"><i class="bi bi-pencil"></i></a>
                                <a href="?delete=<?php echo $i; ?>" class="btn btn-admin-danger btn-sm ms-1" style="padding: 5px 12px;" onclick="return confirm('Delete this testimonial?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><?php echo $editItem ? 'Edit Testimonial' : 'Add Testimonial'; ?></h5>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="">
                    <input type="hidden" name="item_index" value="<?php echo $editIdx !== null ? $editIdx : ''; ?>">

                    <div class="mb-3">
                        <label class="form-label">Client Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($editItem['name'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company / Location</label>
                        <input type="text" name="company" class="form-control" value="<?php echo htmlspecialchars($editItem['company'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quote</label>
                        <textarea name="quote" class="form-control" rows="4" required><?php echo htmlspecialchars($editItem['quote'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo URL</label>
                        <input type="url" name="photo" class="form-control" value="<?php echo htmlspecialchars($editItem['photo'] ?? ''); ?>" placeholder="https://...">
                    </div>
                    <button type="submit" class="btn btn-admin w-100"><?php echo $editItem ? 'Update' : 'Add'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
