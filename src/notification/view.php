<?php
include '../config/config.php';
checkLogin();
checkRole(['staff']);

$conn = new mysqli("localhost", "root", "", "ordering_system");

// Initial load: 12 latest orders
$orders = $conn->query("
    SELECT orderID, customer_name, total_amount, status, order_date, payment_status
    FROM orders 
    ORDER BY order_date DESC
    LIMIT 12
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/view.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">
</head>

<body>
    <?php include '../include/sidebar.php'; ?>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="content">

        <!-- HEADER & SEARCH -->
        <div class="header">
            <h1>View Orders</h1>
            <div class="order-search">
                <input type="text" id="orderSearch" placeholder="Search Customers or Items..." onkeyup="searchOrders()">
            </div>
        </div>

        <!-- ===== ORDERS GRID ===== -->
        <div class="orders-container" id="ordersContainer">
            <?php if ($orders && $orders->num_rows > 0): ?>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <?php include 'order_card.php'; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-orders">No orders for today.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Search function
        function searchOrders() {
            const query = document.getElementById('orderSearch').value.toLowerCase();
            const orders = document.querySelectorAll('.order-card');

            orders.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(query) ? 'block' : 'none';
            });
        }

        // Update food status function
        function updateStatus(orderID, newStatus) {
            fetch('food_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: orderID,
                        status: newStatus
                    })
                })
                .then(res => res.text())
                .then(msg => console.log(msg))
                .catch(err => console.error(err));
        }
    </script>

    <script src="<?= $base_url ?>assets/js/notif.js" defer></script>
</body>

</html>