<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sidebar</title>
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/icon/css/all.min.css">
</head>

<body>
    <div class="sidebar">
        <h2 style="border-bottom: #16161665 solid 2px; font-size: 25px; font-weight: bolder; padding-bottom: 20px; margin-bottom: 15px;">
            Nadine's Admin
        </h2>

        <a href="<?= $base_url ?>index.php">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>

        <?php if ($_SESSION['role'] === 'Admin'): ?>
            <a href="<?= $base_url ?>src/menu/menu.php">
                <i class="fas fa-utensils"></i> Menu
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Staff'): ?>
            <a href="<?= $base_url ?>src/order/orders.php">
                <i class="fas fa-receipt"></i> Orders
            </a>
        <?php endif; ?>
        
        <?php if ($_SESSION['role'] === 'Admin'): ?>
            
            <a href="<?= $base_url ?>src/manage/menu_management.php">
                <i class="fas fa-edit"></i> Menu Management
            </a>

            <a href="<?= $base_url ?>src/accounts/staff.php">
                <i class="fas fa-user-shield"></i> Accounts
            </a>
        <?php endif; ?>

        <a href="<?= $base_url ?>auth/logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

</body>

</html>