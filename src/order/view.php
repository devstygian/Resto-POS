<?php
include '../config/config.php';
checkLogin();
checkRole(['staff']);

$conn = new mysqli("localhost", "root", "", "ordering_system");

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
    <title>View Orders</title>

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/view.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">

</head>

<body>

    <?php include '../include/sidebar.php'; ?>

    <div class="content">
        <div class="header">
            <h1>View Orders</h1>
            <div class="order-search">
                <input type="text" id="orderSearch" placeholder="Search Customers or Addresses..." onkeyup="searchOrders()">
            </div>
        </div>

        <div class="orders-container">
            <?php if ($orders && $orders->num_rows > 0): ?>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <?php
                    $formatted_order_date = date("M d, Y h:i A", strtotime($order['order_date']));
                    $order_id = (int)$order['orderID'];
                    $items_result = $conn->query("
                    SELECT product_name, price, quantity 
                    FROM order_items 
                    WHERE orderID = $order_id
                ");
                    ?>

                    <div class="order-card">
                        <div class="card-header">
                            <h3><?= htmlspecialchars($order['customer_name']); ?></h3>
                            <span class="order-date"><?= $formatted_order_date; ?></span>
                        </div>

                        <div class="card-items">
                            <ul>
                                <?php if ($items_result && $items_result->num_rows > 0): ?>
                                    <?php while ($item = $items_result->fetch_assoc()): ?>
                                        <li>
                                            <span class="item-name"><?= htmlspecialchars($item['product_name']) ?> (x<?= $item['quantity'] ?>)</span>
                                            <span class="item-price">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                        </li>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <li>No items</li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="card-footer">
                            <div class="total">Total: ₱<?= number_format($order['total_amount'], 2); ?></div>
                            <div class="status">
                                <span class="food-status <?= strtolower($order['status']); ?>"><?= htmlspecialchars($order['status']); ?></span>
                                <span class="payment-status <?= strtolower($order['payment_status']); ?>"><?= htmlspecialchars($order['payment_status']); ?></span>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-orders">No orders found</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function searchOrders() {
            const input = document.getElementById('orderSearch').value.toLowerCase();
            const cards = document.querySelectorAll('.order-card');

            cards.forEach(card => {
                const customer = card.querySelector('.card-header h3').innerText.toLowerCase();
                const items = Array.from(card.querySelectorAll('.item-name')).map(el => el.innerText.toLowerCase()).join(' ');

                if (customer.includes(input) || items.includes(input)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

</body>

</html>