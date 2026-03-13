<?php
include '../config.php';
checkLogin();

// Use a single connection
$conn = new mysqli("localhost", "root", "", "ordering_system");

// Fetch all orders
$orders = $conn->query("
    SELECT orderID, customer_name, total_amount, status, order_date, delivery_datetime, address, delivery_type, notes 
    FROM orders 
    ORDER BY order_date DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../assets/orders.css">
    <link rel="stylesheet" href="../icon/css/all.min.css">
</head>

<body>

    <?php include '../sidebar/sidebar.php'; ?>

    <div class="content">
        <h1>Orders management</h1>
        <p style="margin-bottom: 20px;">Manage all orders in the system.</p>

        <div class="orders-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Total (₱)</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Address</th>
                        <th>Delivery Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $orders->fetch_assoc()): ?>
                        <?php
                        $formatted_order_date = date("M d, Y h:i A", strtotime($order['order_date']));
                        $formatted_delivery_date = isset($order['delivery_datetime']) ? date("M d, Y h:i A", strtotime($order['delivery_datetime'])) : '-';
                        $address = $order['address'] ?? '-';
                        $type_of_delivery = $order['delivery_type'] ?? '-';
                        ?>
                        <tr>
                            <td data-label="Customer"><?= htmlspecialchars($order['customer_name']); ?></td>
                            <td data-label="Total">₱<?= number_format($order['total_amount'], 2); ?></td>
                            <td data-label="Order Date"><?= $formatted_order_date; ?></td>
                            <td data-label="Delivery Date"><?= $formatted_delivery_date; ?></td>
                            <td data-label="Address"><?= htmlspecialchars($address); ?></td>
                            <td data-label="Delivery Type"><?= htmlspecialchars($type_of_delivery); ?></td>
                            <td data-label="Status">
                                <select onchange="updateStatus(<?= $order['orderID']; ?>, this.value)" class="status-select">
                                    <option value="Pending" <?= $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Completed" <?= $order['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="Cancelled" <?= $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </td>
                            <td data-label="Actions">
                                <button class="action-btn view-btn" onclick="viewItems(<?= $order['orderID']; ?>)">View Items</button>
                                <button class="action-btn delete-btn" onclick="deleteOrder(<?= $order['orderID']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="itemsModal">
            <div class="modal-content">
                <h3>Order Items</h3>
                <div id="modal-items"></div>
                <h3>Special Instructions</h3>
                <div id="modal-special-instructions"></div>
                <button onclick="closeModal()">Close</button>
            </div>
        </div>

        <!-- JS -->
        <script src="../assets/orders.js"></script>
    </div>
</body>

</html>