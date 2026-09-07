<?php
$page_title = 'Customer Inquiries';
require_once 'includes/admin-header.php';

// Handle status change
if (isset($_GET['status_change']) && isset($_GET['id'])) {
    $newStatus = $_GET['status_change'];
    $inquiryId = (int)$_GET['id'];
    $allowedStatuses = ['new', 'contacted', 'archived'];

    if (in_array($newStatus, $allowedStatuses) && isDbConnected()) {
        dbExecute("UPDATE inquiries SET status = ? WHERE id = ?", [$newStatus, $inquiryId]);
        setFlash('success', 'Inquiry status updated to ' . ucfirst($newStatus) . '.');
    }
    header('Location: inquiries.php' . (isset($_GET['filter']) ? '?filter=' . urlencode($_GET['filter']) : ''));
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $inquiryId = (int)$_GET['delete'];
    if (isDbConnected()) {
        dbExecute("DELETE FROM inquiries WHERE id = ?", [$inquiryId]);
        setFlash('success', 'Inquiry deleted successfully.');
    }
    header('Location: inquiries.php' . (isset($_GET['filter']) ? '?filter=' . urlencode($_GET['filter']) : ''));
    exit;
}

// Filter
$filter = $_GET['filter'] ?? 'all';
$sql = "SELECT * FROM inquiries";
$params = [];

if ($filter !== 'all') {
    $sql .= " WHERE status = ?";
    $params[] = $filter;
}
$sql .= " ORDER BY created_at DESC";

$inquiries = isDbConnected() ? dbFetchAll($sql, $params) : [];

// Counts for filter tabs
$totalCount = 0;
$newCount = 0;
$contactedCount = 0;
$archivedCount = 0;

if (isDbConnected()) {
    $counts = dbFetchAll("SELECT status, COUNT(*) as cnt FROM inquiries GROUP BY status");
    foreach ($counts as $c) {
        $totalCount += (int)$c['cnt'];
        if ($c['status'] === 'new') $newCount = (int)$c['cnt'];
        if ($c['status'] === 'contacted') $contactedCount = (int)$c['cnt'];
        if ($c['status'] === 'archived') $archivedCount = (int)$c['cnt'];
    }
}
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title mb-1">Customer Inquiries</h1>
        <p class="page-subtitle mb-0">Manage customer bookings, event proposals, and contact requests.</p>
    </div>
</div>

<!-- Status Filter Tabs -->
<ul class="nav nav-pills mb-4" style="gap: 8px;">
    <li class="nav-item">
        <a class="nav-link <?php echo $filter === 'all' ? 'active' : ''; ?>" href="inquiries.php?filter=all">
            All Inquiries <span class="badge bg-secondary ms-1"><?php echo $totalCount; ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $filter === 'new' ? 'active' : ''; ?>" href="inquiries.php?filter=new">
            New <span class="badge bg-danger ms-1"><?php echo $newCount; ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $filter === 'contacted' ? 'active' : ''; ?>" href="inquiries.php?filter=contacted">
            Contacted <span class="badge bg-warning text-dark ms-1"><?php echo $contactedCount; ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $filter === 'archived' ? 'active' : ''; ?>" href="inquiries.php?filter=archived">
            Archived <span class="badge bg-dark ms-1"><?php echo $archivedCount; ?></span>
        </a>
    </li>
</ul>

<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">Inquiries List (<?php echo count($inquiries); ?>)</h5>
    </div>
    <div class="admin-card-body p-0">
        <?php if (empty($inquiries)): ?>
            <div class="p-5 text-center text-muted">
                <i class="bi bi-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 12px; color: var(--gold);"></i>
                <p class="mb-0">No inquiries found in this view.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="background-color: transparent; color: #eee;">
                    <thead style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <tr>
                            <th style="padding: 16px; color: rgba(255,255,255,0.7); background-color: transparent;">Date</th>
                            <th style="color: rgba(255,255,255,0.7); background-color: transparent;">Client</th>
                            <th style="color: rgba(255,255,255,0.7); background-color: transparent;">Contact</th>
                            <th style="color: rgba(255,255,255,0.7); background-color: transparent;">Event Details</th>
                            <th style="color: rgba(255,255,255,0.7); background-color: transparent;">Source</th>
                            <th style="color: rgba(255,255,255,0.7); background-color: transparent;">Status</th>
                            <th class="text-end" style="padding-right: 16px; color: rgba(255,255,255,0.7); background-color: transparent;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inquiries as $inq): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); background-color: var(--black-soft, #1a1a1a);">
                            <td style="padding: 16px; font-size: 0.85rem; color: rgba(255,255,255,0.6); white-space: nowrap; background-color: transparent;">
                                <?php echo date('M d, Y', strtotime($inq['created_at'])); ?><br>
                                <small style="color: rgba(255,255,255,0.4);"><?php echo date('h:i A', strtotime($inq['created_at'])); ?></small>
                            </td>
                            <td style="background-color: transparent;">
                                <strong style="color: #fff; font-size: 0.95rem;"><?php echo htmlspecialchars($inq['name']); ?></strong>
                            </td>
                            <td style="background-color: transparent;">
                                <div><a href="mailto:<?php echo htmlspecialchars($inq['email']); ?>" style="color: var(--gold); text-decoration: none;"><i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($inq['email']); ?></a></div>
                                <div style="font-size: 0.85rem; color: rgba(255,255,255,0.6);"><a href="tel:<?php echo htmlspecialchars($inq['phone']); ?>" style="color: inherit; text-decoration: none;"><i class="bi bi-telephone me-1"></i><?php echo htmlspecialchars($inq['phone']); ?></a></div>
                            </td>
                            <td style="background-color: transparent;">
                                <?php if (!empty($inq['event_type'])): ?>
                                    <span class="badge bg-secondary mb-1"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $inq['event_type']))); ?></span><br>
                                <?php endif; ?>
                                <?php if (!empty($inq['event_date'])): ?>
                                    <small style="color: rgba(255,255,255,0.6);"><i class="bi bi-calendar-event me-1"></i><?php echo htmlspecialchars($inq['event_date']); ?></small><br>
                                <?php endif; ?>
                                <?php if (!empty($inq['venue'])): ?>
                                    <small style="color: rgba(255,255,255,0.6);"><i class="bi bi-geo-alt me-1"></i><?php echo htmlspecialchars($inq['venue']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td style="background-color: transparent;">
                                <span class="badge" style="background: rgba(201,169,98,0.15); color: var(--gold); border: 1px solid rgba(201,169,98,0.3);">
                                    <?php echo $inq['source'] === 'modal_enquiry' ? 'Enquiry Modal' : 'Contact Page'; ?>
                                </span>
                            </td>
                            <td style="background-color: transparent;">
                                <?php if ($inq['status'] === 'new'): ?>
                                    <span class="badge bg-danger">New</span>
                                <?php elseif ($inq['status'] === 'contacted'): ?>
                                    <span class="badge bg-warning text-dark">Contacted</span>
                                <?php else: ?>
                                    <span class="badge bg-dark">Archived</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end" style="padding-right: 16px; white-space: nowrap; background-color: transparent;">
                                <!-- View Message Button -->
                                <button type="button" class="btn btn-sm btn-outline-light me-1" data-bs-toggle="modal" data-bs-target="#inqModal<?php echo $inq['id']; ?>" title="View Message" style="color: #fff; border-color: rgba(255,255,255,0.4);">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <!-- Status toggle dropdown -->
                                <div class="btn-group me-1">
                                    <button type="button" class="btn btn-sm btn-outline-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Change Status">
                                        <i class="bi bi-tag"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                        <li><a class="dropdown-item" href="inquiries.php?status_change=new&id=<?php echo $inq['id']; ?>&filter=<?php echo $filter; ?>"><i class="bi bi-circle-fill text-danger me-2"></i>Mark as New</a></li>
                                        <li><a class="dropdown-item" href="inquiries.php?status_change=contacted&id=<?php echo $inq['id']; ?>&filter=<?php echo $filter; ?>"><i class="bi bi-circle-fill text-warning me-2"></i>Mark as Contacted</a></li>
                                        <li><a class="dropdown-item" href="inquiries.php?status_change=archived&id=<?php echo $inq['id']; ?>&filter=<?php echo $filter; ?>"><i class="bi bi-circle-fill text-secondary me-2"></i>Mark as Archived</a></li>
                                    </ul>
                                </div>

                                <!-- Delete button -->
                                <a href="inquiries.php?delete=<?php echo $inq['id']; ?>&filter=<?php echo $filter; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to permanently delete this inquiry?');" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Detail for each inquiry -->
                        <div class="modal fade" id="inqModal<?php echo $inq['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="background: #1c1c1c; border: 1px solid rgba(201,169,98,0.3); color: #fff;">
                                    <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                        <h5 class="modal-title" style="color: var(--gold); font-family: 'Cormorant Garamond', serif;">Inquiry from <?php echo htmlspecialchars($inq['name']); ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Submitted On</small>
                                            <p class="mb-0"><?php echo date('F d, Y \a\t h:i A', strtotime($inq['created_at'])); ?></p>
                                        </div>
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Email</small>
                                                <p class="mb-0"><a href="mailto:<?php echo htmlspecialchars($inq['email']); ?>" style="color: var(--gold);"><?php echo htmlspecialchars($inq['email']); ?></a></p>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Phone</small>
                                                <p class="mb-0"><a href="tel:<?php echo htmlspecialchars($inq['phone']); ?>" style="color: #fff;"><?php echo htmlspecialchars($inq['phone']); ?></a></p>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Event Type</small>
                                                <p class="mb-0"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $inq['event_type'] ?? 'N/A'))); ?></p>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Event Date</small>
                                                <p class="mb-0"><?php echo htmlspecialchars($inq['event_date'] ?: 'N/A'); ?></p>
                                            </div>
                                        </div>
                                        <?php if (!empty($inq['venue'])): ?>
                                        <div class="mb-3">
                                            <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Venue / Location</small>
                                            <p class="mb-0"><?php echo htmlspecialchars($inq['venue']); ?></p>
                                        </div>
                                        <?php endif; ?>
                                        <div class="mb-3">
                                            <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Message</small>
                                            <div style="background: #0a0a0a; border: 1px solid rgba(255,255,255,0.08); padding: 15px; border-radius: 4px; white-space: pre-wrap; margin-top: 4px; font-size: 0.9rem;">
                                                <?php echo htmlspecialchars($inq['message'] ?: 'No additional message provided.'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1);">
                                        <a href="mailto:<?php echo htmlspecialchars($inq['email']); ?>?subject=Inquiry%20Response%20-%20Gourmet%20Affair" class="btn btn-sm btn-gold">
                                            <i class="bi bi-reply-fill me-1"></i> Reply via Email
                                        </a>
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>