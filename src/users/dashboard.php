<?php
// Use a single connection
$conn = new mysqli("localhost", "root", "", "ordering_system");

// Fetch all orders (fallback display)
$orders = $conn->query("
    SELECT orderID, customer_name, total_amount, status, order_date, delivery_datetime, address, delivery_type, notes 
    FROM orders 
    ORDER BY order_date DESC

     LIMIT 5
");
?>

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
                <th>Items</th>

            </tr>
        </thead>

        <tbody id="ordersTableBody">
            <?php while ($order = $orders->fetch_assoc()): ?>
                <?php
                $formatted_order_date = date("M d, Y h:i A", strtotime($order['order_date']));
                $formatted_delivery_date = isset($order['delivery_datetime']) ? date("M d, Y h:i A", strtotime($order['delivery_datetime'])) : '-';
                $address = $order['address'] ?? '-';
                $type_of_delivery = $order['delivery_type'] ?? '-';
                ?>
                <tr>
                    <td><?= htmlspecialchars($order['customer_name']); ?></td>
                    <td>₱<?= number_format($order['total_amount'], 2); ?></td>
                    <td><?= $formatted_order_date; ?></td>
                    <td><?= $formatted_delivery_date; ?></td>
                    <td><?= htmlspecialchars($address); ?></td>
                    <td><?= htmlspecialchars($type_of_delivery); ?></td>
                    <td><?= htmlspecialchars($order['status']); ?></td>
                    <td><?= htmlspecialchars($order['orderID']); ?></td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>