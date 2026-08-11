<?php
$page_title = 'Menu Manager';
require_once 'includes/admin-header.php';

$menu = readData('menu');
$categories = [
    'contemporary_european' => 'Contemporary European',
    'pan_asian_fusion' => 'Pan-Asian Fusion',
    'farm_to_table' => 'Farm-to-Table'
];

// Handle delete
if (isset($_GET['delete']) && isset($_GET['cat'])) {
    $cat = $_GET['cat'];
    $idx = (int)$_GET['delete'];
    if (isset($menu[$cat][$idx])) {
        array_splice($menu[$cat], $idx, 1);
        writeData('menu', $menu);
        setFlash('success', 'Menu item deleted successfully!');
    }
    header('Location: menu-manager.php');
    exit;
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat = $_POST['category'] ?? '';
    $idx = $_POST['item_index'] ?? '';
    $item = [
        'name' => $_POST['name'] ?? '',
        'desc' => $_POST['desc'] ?? '',
        'price' => $_POST['price'] ?? ''
    ];

    if ($idx !== '' && isset($menu[$cat][$idx])) {
        $menu[$cat][$idx] = $item;
        setFlash('success', 'Menu item updated successfully!');
    } else {
        $menu[$cat][] = $item;
        setFlash('success', 'Menu item added successfully!');
    }
    writeData('menu', $menu);
    header('Location: menu-manager.php');
    exit;
}

$activeCat = $_GET['category'] ?? 'contemporary_european';
$editItem = null;
$editIdx = null;
if (isset($_GET['edit']) && isset($_GET['cat'])) {
    $editIdx = (int)$_GET['edit'];
    $editItem = $menu[$_GET['cat']][$editIdx] ?? null;
    $activeCat = $_GET['cat'];
}
?>

<h1 class="page-title">Menu Manager</h1>
<p class="page-subtitle">Add, edit, or remove menu items across all cuisine categories.</p>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5>Menu Items</h5>
            </div>
            <div class="admin-card-body p-0">
                <ul class="nav nav-tabs-admin px-4 pt-3">
                    <?php foreach ($categories as $key => $label): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $activeCat === $key ? 'active' : ''; ?>" href="?category=<?php echo $key; ?>"><?php echo $label; ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="p-4">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Dish Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menu[$activeCat] ?? [] as $i => $item): ?>
                            <tr>
                                <td style="color: #fff; font-weight: 500;"><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['desc']); ?></td>
                                <td style="color: var(--gold); font-weight: 600;"><?php echo htmlspecialchars($item['price']); ?></td>
                                <td>
                                    <a href="?category=<?php echo $activeCat; ?>&edit=<?php echo $i; ?>&cat=<?php echo $activeCat; ?>" class="btn btn-admin-outline btn-sm" style="padding: 5px 12px;"><i class="bi bi-pencil"></i></a>
                                    <a href="?delete=<?php echo $i; ?>&cat=<?php echo $activeCat; ?>" class="btn btn-admin-danger btn-sm ms-1" style="padding: 5px 12px;" onclick="return confirm('Delete this item?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><?php echo $editItem ? 'Edit Item' : 'Add New Item'; ?></h5>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="">
                    <input type="hidden" name="item_index" value="<?php echo $editIdx !== null ? $editIdx : ''; ?>">

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <?php foreach ($categories as $key => $label): ?>
                            <option value="<?php echo $key; ?>" <?php echo $activeCat === $key ? 'selected' : ''; ?>><?php echo $label; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dish Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($editItem['name'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="desc" class="form-control" rows="3"><?php echo htmlspecialchars($editItem['desc'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($editItem['price'] ?? ''); ?>" placeholder="$00">
                    </div>
                    <button type="submit" class="btn btn-admin w-100"><?php echo $editItem ? 'Update Item' : 'Add Item'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
