<?php
$page_title = 'Manage Images';
require_once 'includes/admin-header.php';

$content = readData('content');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section = $_POST['section'] ?? '';
    $field = $_POST['field'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploaded = uploadImage($_FILES['image'], $section);
        if ($uploaded) {
            // Update content JSON
            $keys = explode('_', $field);
            if (count($keys) >= 2) {
                $page = $keys[0];
                $imgField = implode('_', array_slice($keys, 1));
                if (isset($content[$page])) {
                    $content[$page][$imgField] = $uploaded;
                    writeData('content', $content);
                    setFlash('success', 'Image uploaded successfully!');
                }
            }
        } else {
            setFlash('danger', 'Failed to upload image. Please try again.');
        }
    } elseif (!empty($_POST['url'])) {
        $keys = explode('_', $field);
        if (count($keys) >= 2) {
            $page = $keys[0];
            $imgField = implode('_', array_slice($keys, 1));
            if (isset($content[$page])) {
                $content[$page][$imgField] = $_POST['url'];
                writeData('content', $content);
                setFlash('success', 'Image URL updated successfully!');
            }
        }
    }
    header('Location: images.php');
    exit;
}

$imageFields = [
    ['key' => 'home_hero_slide_1_bg', 'label' => 'Hero Slide 1 Background', 'page' => 'home'],
    ['key' => 'home_hero_slide_2_bg', 'label' => 'Hero Slide 2 Background', 'page' => 'home'],
    ['key' => 'home_hero_slide_3_bg', 'label' => 'Hero Slide 3 Background', 'page' => 'home'],
    ['key' => 'home_about_img_1', 'label' => 'About Section Image 1', 'page' => 'home'],
    ['key' => 'home_about_img_2', 'label' => 'About Section Image 2', 'page' => 'home'],
    ['key' => 'home_quality_img', 'label' => 'Quality/Ingredients Image', 'page' => 'home'],
    ['key' => 'about_page_story_img_1', 'label' => 'About Page Story Image 1', 'page' => 'about_page'],
    ['key' => 'about_page_story_img_2', 'label' => 'About Page Story Image 2', 'page' => 'about_page'],
];
?>

<h1 class="page-title">Manage Images</h1>
<p class="page-subtitle">Upload new images or update image URLs for your website sections.</p>

<div class="row g-4">
    <?php foreach ($imageFields as $img): 
        $keys = explode('_', $img['key']);
        $page = $keys[0];
        $field = implode('_', array_slice($keys, 1));
        $current = $content[$page][$field] ?? '';
    ?>
    <div class="col-lg-4 col-md-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><?php echo $img['label']; ?></h5>
            </div>
            <div class="admin-card-body">
                <?php if ($current): ?>
                <img src="<?php echo '../' . $current; ?>" class="img-preview mb-3" alt="Current image">
                <p class="mb-3" style="font-size: 0.75rem; color: rgba(255,255,255,0.3); word-break: break-all;"><?php echo $current; ?></p>
                <?php else: ?>
                <div class="img-preview mb-3 d-flex align-items-center justify-content-center" style="background: var(--black-soft);">
                    <span style="color: rgba(255,255,255,0.2); font-size: 0.8rem;">No image set</span>
                </div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="section" value="<?php echo $img['page']; ?>">
                    <input type="hidden" name="field" value="<?php echo $img['key']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Upload New Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Or Enter Image URL</label>
                        <input type="url" name="url" class="form-control" placeholder="https://..." value="<?php echo strpos($current ?? '', 'http') === 0 ? $current : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-admin btn-sm w-100">Update Image</button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
