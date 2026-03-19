<?php
include 'src/config/config.php';
checkLogin();

// Total Sales
$total_amount = $conn->query("
    SELECT SUM(od.price * od.quantity) AS total
    FROM orderdetail od
")->fetch_assoc()['total'] ?? 0;

// Total Orders (count of items sold)
$totalOrders = $conn->query("
    SELECT COUNT(DISTINCT orderID) AS count
    FROM orderdetail
")->fetch_assoc()['count'] ?? 0;

// Total Customers
$totalCustomers = $conn->query("
    SELECT COUNT(DISTINCT customer_name) AS count
    FROM orders
")->fetch_assoc()['count'] ?? 0;

// Today's Sales
$todaySales = $conn->query("
    SELECT SUM(od.price * od.quantity) AS total
    FROM orderdetail od
    JOIN orders o ON od.orderID = o.orderID
    WHERE DATE(o.order_date) = CURDATE()
")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php include 'src/include/sidebar.php'; ?>

    <div class="content">
        <!-- TOPBAR -->
        <div class="topbar">
            <button id="sidebar-toggle"><i class="fas fa-bars"></i></button>
            <h1>Dashboard</h1>
            <p>Welcome, <?= isset($_SESSION['users']) ? $_SESSION['users'] : 'Guest' ?></p>
        </div>

        <!-- STAT CARDS -->
        <div class="cards">
            <div class="card">
                <div class="card-icon sales"><i class="fas fa-coins"></i></div>
                <div>
                    <h3>Total Sales</h3>
                    <h2>₱<?= number_format($total_amount, 2) ?></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-icon orders"><i class="fas fa-shopping-cart"></i></div>
                <div>
                    <h3>Total Orders</h3>
                    <h2><?= $totalOrders ?></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-icon customers"><i class="fas fa-users"></i></div>
                <div>
                    <h3>Total Customers</h3>
                    <h2><?= $totalCustomers ?></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-icon today"><i class="fas fa-calendar-day"></i></div>
                <div>
                    <h3>Today's Sales</h3>
                    <h2>₱<?= number_format($todaySales, 2) ?></h2>
                </div>
            </div>
        </div>

        <!-- RECENT ORDERS -->
        <h2 style="margin-bottom: 10px;">Recent Orders</h2>
        <?php include 'src/dashboard/recent_orders.php'; ?>

        <h1 style="margin-bottom: 50px;"></h1>

        <!-- MONTHLY SALES CHART -->
        <h2 style="margin-bottom: 10px;">Monthly Sale Chart</h2>
        <?php include 'src/dashboard/monthly_sales.php'; ?>

    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Sidebar toggle
        const toggleBtn = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('show'));
    </script>

</body>

</html>