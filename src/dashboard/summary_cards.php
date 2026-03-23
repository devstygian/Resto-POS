<?php

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
        <div class="card-icon orders"><i class="fas fa-box"></i></div>
        <div>
            <h3>Total Items Sold</h3>
            <h2><?= $totalItems ?></h2>
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
        <div class="card-icon today"><i class="fas fa-receipt"></i></div>
        <div>
            <h3>Today's Orders</h3>
            <h2><?= $todayOrders ?></h2>
        </div>
    </div>

</div>