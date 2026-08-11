<?php
$page_title = 'Gallery Manager';
require_once 'includes/admin-header.php';

$gallery = readData('gallery');

// Handle delete
if (isset($_GET['delete'])) {
    $idx = (int)$_GET['delete'];
    if (isset($gallery[$idx])) {
        // Delete uploaded file if local
        if (strpos($gallery[$idx]['src'], 'admin/uploads/') === 0) {
            deleteImage($gallery[$idx]['src']);
        }
        array_splice($gallery, $idx, 1);
        writeData('gallery', $gallery);
        setFlash('success', 'Gallery image removed successfully!');
    }
    header('Location: gallery-manager.php');
    exit;
}

// Handle add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = ['title' => $_POST['title'] ?? '', 'location' => $_POST['location'] ?? ''];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploaded = uploadImage($_FILES['image'], 'gallery');
        if ($uploaded) {
            $item['src'] = $uploaded;
        }
    } elseif (!empty($_POST['url'])) {
        $item['src'] = $_POST['url'];
    }

    if (!empty($item['src'])) {
        $gallery[] = $item;
        writeData('gallery', $gallery);
        setFlash('success', 'Image added to gallery!');
    }
    header('Location: gallery-manager.php');
    exit;
}
?>

<h1 class="page-title">Gallery Manager</h1>
<p class="page-subtitle">Upload and manage images in your website gallery.</p>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5>Add New Image</h5>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Or Image URL</label>
                        <input type="url" name="url" class="form-control" placeholder="https://...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Wedding Reception">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. New York, USA">
                    </div>
                    <button type="submit" class="btn btn-admin w-100">Add to Gallery</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5>Gallery Images (<?php echo count($gallery); ?>)</h5>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    <?php foreach ($gallery as $i => $img): ?>
                    <div class="col-md-4 col-sm-6">
                        <div style="position: relative; border: 1px solid rgba(255,255,255,0.05);">
                            <img src="<?php echo '../' . $img['src']; ?>" style="width: 100%; height: 160px; object-fit: cover;" alt="">
                            <div style="padding: 12px;">
                                <p class="mb-1" style="color: #fff; font-size: 0.85rem; font-weight: 500;"><?php echo htmlspecialchars($img['title']); ?></p>
                                <p class="mb-2" style="color: var(--gold); font-size: 0.75rem;"><?php echo htmlspecialchars($img['location']); ?></p>
                                <a href="?delete=<?php echo $i; ?>" class="btn btn-admin-danger btn-sm w-100" onclick="return confirm('Remove this image?')"><i class="bi bi-trash"></i> Remove</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
