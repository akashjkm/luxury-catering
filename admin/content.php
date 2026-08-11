<?php
$page_title = 'Edit Content';
require_once 'includes/admin-header.php';

$content = readData('content');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page = $_POST['page'] ?? '';
    if (isset($content[$page])) {
        foreach ($_POST as $key => $val) {
            if ($key !== 'page' && $key !== 'save_content') {
                $content[$page][$key] = $val;
            }
        }
        writeData('content', $content);
        setFlash('success', 'Content updated successfully!');
    }
    header('Location: content.php?page=' . $page);
    exit;
}

$activePage = $_GET['page'] ?? 'home';
$pages = [
    'home' => 'Homepage',
    'about_page' => 'About Page'
];
?>

<h1 class="page-title">Edit Content</h1>
<p class="page-subtitle">Update text content for different pages and sections of your website.</p>

<ul class="nav nav-tabs-admin">
    <?php foreach ($pages as $key => $label): ?>
    <li class="nav-item">
        <a class="nav-link <?php echo $activePage === $key ? 'active' : ''; ?>" href="?page=<?php echo $key; ?>"><?php echo $label; ?></a>
    </li>
    <?php endforeach; ?>
</ul>

<div class="admin-card">
    <div class="admin-card-header">
        <h5><?php echo $pages[$activePage] ?? 'Homepage'; ?> Content</h5>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="">
            <input type="hidden" name="page" value="<?php echo $activePage; ?>">

            <?php if ($activePage === 'home'): ?>

            <h6 style="color: var(--gold); margin: 25px 0 15px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Hero Slide 1</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Eyebrow Text</label>
                    <input type="text" name="hero_slide_1_eyebrow" class="form-control" value="<?php echo htmlspecialchars($content['home']['hero_slide_1_eyebrow'] ?? ''); ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Title</label>
                    <input type="text" name="hero_slide_1_title" class="form-control" value="<?php echo htmlspecialchars($content['home']['hero_slide_1_title'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Subtitle</label>
                    <textarea name="hero_slide_1_subtitle" class="form-control" rows="2"><?php echo htmlspecialchars($content['home']['hero_slide_1_subtitle'] ?? ''); ?></textarea>
                </div>
            </div>

            <h6 style="color: var(--gold); margin: 25px 0 15px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Hero Slide 2</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Eyebrow Text</label>
                    <input type="text" name="hero_slide_2_eyebrow" class="form-control" value="<?php echo htmlspecialchars($content['home']['hero_slide_2_eyebrow'] ?? ''); ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Title</label>
                    <input type="text" name="hero_slide_2_title" class="form-control" value="<?php echo htmlspecialchars($content['home']['hero_slide_2_title'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Subtitle</label>
                    <textarea name="hero_slide_2_subtitle" class="form-control" rows="2"><?php echo htmlspecialchars($content['home']['hero_slide_2_subtitle'] ?? ''); ?></textarea>
                </div>
            </div>

            <h6 style="color: var(--gold); margin: 25px 0 15px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Hero Slide 3</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Eyebrow Text</label>
                    <input type="text" name="hero_slide_3_eyebrow" class="form-control" value="<?php echo htmlspecialchars($content['home']['hero_slide_3_eyebrow'] ?? ''); ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Title</label>
                    <input type="text" name="hero_slide_3_title" class="form-control" value="<?php echo htmlspecialchars($content['home']['hero_slide_3_title'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Subtitle</label>
                    <textarea name="hero_slide_3_subtitle" class="form-control" rows="2"><?php echo htmlspecialchars($content['home']['hero_slide_3_subtitle'] ?? ''); ?></textarea>
                </div>
            </div>

            <h6 style="color: var(--gold); margin: 25px 0 15px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">About Section</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Eyebrow</label>
                    <input type="text" name="about_eyebrow" class="form-control" value="<?php echo htmlspecialchars($content['home']['about_eyebrow'] ?? ''); ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Title</label>
                    <input type="text" name="about_title" class="form-control" value="<?php echo htmlspecialchars($content['home']['about_title'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Paragraph 1</label>
                    <textarea name="about_text_1" class="form-control" rows="3"><?php echo htmlspecialchars($content['home']['about_text_1'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Paragraph 2</label>
                    <textarea name="about_text_2" class="form-control" rows="3"><?php echo htmlspecialchars($content['home']['about_text_2'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Paragraph 3</label>
                    <textarea name="about_text_3" class="form-control" rows="3"><?php echo htmlspecialchars($content['home']['about_text_3'] ?? ''); ?></textarea>
                </div>
            </div>

            <h6 style="color: var(--gold); margin: 25px 0 15px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Quality Section</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="quality_title" class="form-control" value="<?php echo htmlspecialchars($content['home']['quality_title'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Badge Number</label>
                    <input type="text" name="quality_badge_number" class="form-control" value="<?php echo htmlspecialchars($content['home']['quality_badge_number'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Badge Text</label>
                    <input type="text" name="quality_badge_text" class="form-control" value="<?php echo htmlspecialchars($content['home']['quality_badge_text'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Paragraph 1</label>
                    <textarea name="quality_text_1" class="form-control" rows="3"><?php echo htmlspecialchars($content['home']['quality_text_1'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Paragraph 2</label>
                    <textarea name="quality_text_2" class="form-control" rows="3"><?php echo htmlspecialchars($content['home']['quality_text_2'] ?? ''); ?></textarea>
                </div>
            </div>

            <h6 style="color: var(--gold); margin: 25px 0 15px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">CTA Banner</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Title</label>
                    <input type="text" name="cta_title" class="form-control" value="<?php echo htmlspecialchars($content['home']['cta_title'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Subtitle</label>
                    <textarea name="cta_subtitle" class="form-control" rows="2"><?php echo htmlspecialchars($content['home']['cta_subtitle'] ?? ''); ?></textarea>
                </div>
            </div>

            <?php elseif ($activePage === 'about_page'): ?>

            <h6 style="color: var(--gold); margin: 25px 0 15px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Our Story</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Title</label>
                    <input type="text" name="story_title" class="form-control" value="<?php echo htmlspecialchars($content['about_page']['story_title'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Paragraph 1</label>
                    <textarea name="story_text_1" class="form-control" rows="3"><?php echo htmlspecialchars($content['about_page']['story_text_1'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Paragraph 2</label>
                    <textarea name="story_text_2" class="form-control" rows="3"><?php echo htmlspecialchars($content['about_page']['story_text_2'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Paragraph 3</label>
                    <textarea name="story_text_3" class="form-control" rows="3"><?php echo htmlspecialchars($content['about_page']['story_text_3'] ?? ''); ?></textarea>
                </div>
            </div>

            <?php endif; ?>

            <div class="mt-4">
                <button type="submit" name="save_content" class="btn btn-admin">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
