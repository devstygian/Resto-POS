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

// Total Orders
$totalOrders = $conn->query("
    SELECT COUNT(*) AS count
    FROM orders
    WHERE payment_status = 'Paid'
")->fetch_assoc()['count'] ?? 0;

// Total Customers
$totalCustomers = $conn->query("
    SELECT COUNT(DISTINCT customer_name) AS count
    FROM orders
    WHERE payment_status = 'Paid'
")->fetch_assoc()['count'] ?? 0;

// Today's Sales
$todaySales = $conn->query("
    SELECT SUM(oi.price * oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.order_date) = CURDATE()
      AND o.payment_status = 'Paid'
")->fetch_assoc()['total'] ?? 0;

// Total Items Sold (sum of quantities for paid orders)
$totalItems = $conn->query("
    SELECT SUM(oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE o.payment_status = 'Paid'
")->fetch_assoc()['total'] ?? 0;

// Today's Orders
$todayOrders = $conn->query("
    SELECT COUNT(*) AS count
    FROM orders
    WHERE DATE(order_date) = CURDATE()
      AND payment_status = 'Paid'
")->fetch_assoc()['count'] ?? 0;

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- header.php -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <?php include 'src/include/sidebar.php'; ?>

    <div class="content">

        <!-- TOPBAR -->
        <div class="topbar">

            <h1>Dashboard</h1>
            <p>
                Welcome, <?= $_SESSION['users'] ?? 'Guest' ?>
                (<?= $_SESSION['role'] ?? 'Unknown' ?>)
                <i class="fas fa-user-circle"></i>
            </p>
        </div>

        <!-- SUMMARY CARDS -->
        <h2 style="margin-bottom: -4%;">Summary Report</h2>
        <?php include 'src/dashboard/summary_cards.php'; ?>

        <!-- RECENT ORDERS -->
        <h2 style="margin-bottom: 10px;">Recent Orders</h2>
        <?php include 'src/dashboard/recent_orders.php'; ?>

    </div>
    <!--
    <script src="<?= $base_url ?>assets/js/notif.js"></script>
    -->
</body>

</html>