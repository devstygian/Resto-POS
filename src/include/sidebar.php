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
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <script src="<?= $base_url ?>assets/js/notif.js" defer></script>
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

            <a href="#" class="<?= $currentPage == 'customer.php' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Customer
            </a>

            <a href="<?= $base_url ?>src/dashboard/stats.php" class="<?= $currentPage == 'stats.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i> Statistics
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'staff'): ?>
            <a href="<?= $base_url ?>src/order/view.php" class="view-orders-link <?= $currentPage == 'view.php' ? 'active' : '' ?>">
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
</body>

</html>