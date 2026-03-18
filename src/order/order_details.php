<?php
include '../config/config.php';
checkLogin();

// Validate order_id
if (!isset($_GET['order_id'])) {
    die("Invalid order.");
}

$order_id = intval($_GET['order_id']);

// Fetch order using prepared statement
$stmt = $conn->prepare("
    SELECT orderID, customer_name, order_date, total_amount, notes 
    FROM orders 
    WHERE orderID = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

// If order not found
if (!$order) {
    die("Order not found.");
}

// Fetch items from order_items
$stmt_items = $conn->prepare("
    SELECT product_name, price, quantity
    FROM order_items
    WHERE orderID = ?
");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items_result = $stmt_items->get_result();

$items = [];
while ($row = $items_result->fetch_assoc()) {
    $items[] = $row;
}

// Return JSON if called via AJAX
if (isset($_GET['ajax'])) {
    $response = [
        'items' => $items,
        'notes' => $order['notes'] ?? ''
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="../assets/css/menu.css">
</head>

<body>

    <div class="sidebar">
        <h2>Nadine' Owner</h2>
        <a href="../index.php">Dashboard</a>
        <a href="../menu.php">Order Menu</a>
        <a href="../orders.php">Orders</a>
        <a href="../customers.php">Customers</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="content">

        <h1>Order #<?= htmlspecialchars($order['orderID']) ?></h1>

        <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        <p><strong>Total:</strong> ₱<?= number_format($order['total_amount'], 2) ?></p>
        <p><strong>Notes:</strong> <?= htmlspecialchars($order['notes'] ?? '-') ?></p>

        <h2>Items</h2>

        <table class="orders-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>

                <?php if (count($items) > 0): ?>
                    <?php foreach ($items as $item): ?>

                        <tr>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td>₱<?= number_format($item['price'], 2) ?></td>
                            <td><?= intval($item['quantity']) ?></td>
                            <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>

                    <tr>
                        <td colspan="4" style="text-align:center;">No items found</td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>

    </div>

</body>

</html>