<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detect current page
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
</head>

<body>
    <div class="sidebar">
        <h2 style="border-bottom: #16161665 solid 2px; font-size: 25px; font-weight: bolder; padding-bottom: 20px; margin-bottom: 15px;">
            Nadine's <?= $_SESSION['role'] ?? 'Unknown' ?>
        </h2>

        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'staff'): ?>
            <a href="<?= $base_url ?>index.php" class="<?= $currentPage == 'index.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="<?= $base_url ?>src/menu/menu.php" class="<?= $currentPage == 'menu.php' ? 'active' : '' ?>">
                <i class="fas fa-utensils"></i> Menu
            </a>

            <a href="<?= $base_url ?>src/order/orders.php" class="<?= $currentPage == 'orders.php' ? 'active' : '' ?>">
                <i class="fas fa-receipt"></i> Orders
            </a>

            <a href="<?= $base_url ?>src/manage/menu_management.php" class="<?= $currentPage == 'menu_management.php' ? 'active' : '' ?>">
                <i class="fas fa-edit"></i> Custom Menu
            </a>

            <a href="<?= $base_url ?>src/accounts/staff.php" class="<?= $currentPage == 'staff.php' ? 'active' : '' ?>">
                <i class="fas fa-user-shield"></i> Accounts
            </a>

            <a href="<?= $base_url ?>src/users/customers.php" class="<?= $currentPage == 'customers.php' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Customer
            </a>

            <a href="<?= $base_url ?>src/dashboard/stats.php" class="<?= $currentPage == 'stats.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i> Statistics
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'staff'): ?>
            <a href="<?= $base_url ?>src/notification/view.php" class="view-orders-link <?= $currentPage == 'view.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i> View Orders
                <span class="notif-wrapper">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge">0</span>
                    <div class="notif-container"></div>
                </span>
            </a>
        <?php endif; ?>

        <a href="<?= $base_url ?>auth/logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!--Modal-->
    <div class="modal fade" id="error-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modal-title">Something Went Wrong</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modal-message">An unexpected error occurred.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal-close-btn">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?= $base_url ?>assets/js/notif.js" defer></script>

</body>
</html>