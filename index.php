<?php
include 'src/config/config.php';
checkLogin();
checkRole(['admin', 'staff']);

// Total Sales (only paid orders)
$total_amount = $conn->query("
    SELECT SUM(oi.price * oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE o.payment_status = 'Paid'
")->fetch_assoc()['total'] ?? 0;

// Total Orders (transactions with paid orders)
$totalOrders = $conn->query("
    SELECT COUNT(*) AS count
    FROM orders
    WHERE payment_status = 'Paid'
")->fetch_assoc()['count'] ?? 0;

// Total Items Sold (sum of quantities for paid orders)
$totalItems = $conn->query("
    SELECT SUM(oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE o.payment_status = 'Paid'
")->fetch_assoc()['total'] ?? 0;

// Total Customers (unique customers from paid orders)
$totalCustomers = $conn->query("
    SELECT COUNT(DISTINCT customer_name) AS count
    FROM orders
    WHERE payment_status = 'Paid'
")->fetch_assoc()['count'] ?? 0;

// Today's Sales (sum of prices from paid orders today)
$todaySales = $conn->query("
    SELECT SUM(oi.price * oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.order_date) = CURDATE()
      AND o.payment_status = 'Paid'
")->fetch_assoc()['total'] ?? 0;

// Total Amount Paid (all-time, for fact report)
$total_amount_refunded = $conn->query("
    SELECT SUM(oi.price * oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE o.payment_status = 'Refunded'
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
            <p>Welcome, <?= isset($_SESSION['users']) ? $_SESSION['users'] : 'Guest' ?> (<?= isset($_SESSION['role']) ? $_SESSION['role'] : 'Unknown' ?>)</p>
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
                <div class="card-icon orders"><i class="fas fa-money-bill"></i></div>
                <div>
                    <h3>Refunded Orders</h3>
                    <h2>₱<?= number_format($total_amount_refunded, 2) ?></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-icon today"><i class="fas fa-calendar-day"></i></div>
                <div>
                    <h3>Today's Sales</h3>
                    <h2>₱<?= number_format($todaySales, 2) ?></h2>
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
                <div class="card-icon orders"><i class="fas fa-box"></i></div>
                <div>
                    <h3>Total Items Sold</h3>
                    <h2><?= $totalItems ?></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-icon customers"><i class="fas fa-users"></i></div>
                <div>
                    <h3>Total Customers</h3>
                    <h2><?= $totalCustomers ?></h2>
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

        <!-- Weely Sales Chart -->
        <h2 style="margin-bottom: 10px; margin-top: 50px;">Weekly Sale Chart</h2>
        <?php include 'src/dashboard/weekly_sales.php'; ?>

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