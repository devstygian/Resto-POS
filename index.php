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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 0;
            left: 230px;
            right: 0;
            height: 70px;
            background-color: transparent;
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 45px;
            padding-bottom: 35px;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            
        }

        /* Topbar content */
        .topbar h1 {
            font-size: 1.8rem;
            margin: 0;
        }

        .topbar p {
            font-size: 16px;
            color: #111111;
            display: flex;
            align-items: center;
            gap: 8px;
        }

    </style>
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
        <h2 style="margin-bottom: -4%; margin-top:80px;">Summary Report</h2>
        <?php include 'src/dashboard/summary_cards.php'; ?>

        <!-- RECENT ORDERS -->
        <h2 style="margin-bottom: 10px;">Recent Orders</h2>
        <?php include 'src/dashboard/recent_orders.php'; ?>

    </div>

    <!--Example integration-->
<!--    <button type="button" class="btn btn-warning"-->
<!--            onclick="ErrorHandler.show('The manual test was successful!', 'Manual Test')">-->
<!--        Test Error Modal-->
<!--    </button>-->

</body>

</html>