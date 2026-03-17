<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sidebar</title>
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="../icon/css/all.min.css">
</head>

<body>
    <div class="sidebar">
        <h2><i class="fas fa-store"></i> Nadine' Owner</h2>

        <a href="<?= $base_url ?>index.php">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>

        <a href="<?= $base_url ?>menu/menu.php">
            <i class="fas fa-utensils"></i> Menu
        </a>

        <a href="<?= $base_url ?>order/orders.php">
            <i class="fas fa-receipt"></i> Orders
        </a>

        <a href="<?= $base_url ?>users/customers.php">
            <i class="fas fa-users"></i> Customers
        </a>

        <a href="<?= $base_url ?>M_management/menu_management.php">
            <i class="fas fa-edit"></i> Menu Management
        </a>

        <a href="<?= $base_url ?>acc_management/staff.php">
            <i class="fas fa-user-shield"></i> Accounts
        </a>

        <a href="<?= $base_url ?>auth/logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

</body>

</html>