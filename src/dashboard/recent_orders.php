<?php
$conn = new mysqli("localhost", "root", "", "ordering_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orders = $conn->query("
    SELECT orderID, customer_name, total_amount, status, order_date, payment_status
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
                <th>Order Date</th>
                <th>Items</th>
                <th>Total (₱)</th>
                <th>Status</th>
                <th>Payment Status</th>


            </tr>
        </thead>

        <tbody id="ordersTableBody">
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
                    <tr>
                        <td><?= htmlspecialchars($order['customer_name']); ?></td>

                        <td><?= $formatted_order_date; ?></td>

                        <td>
                            <ul>
                                <?php if ($items_result && $items_result->num_rows > 0): ?>
                                    <?php while ($item = $items_result->fetch_assoc()): ?>
                                        <li>
                                            <?= htmlspecialchars($item['product_name']) ?>
                                            (x<?= $item['quantity'] ?>) -
                                            ₱<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                        </li>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <li>No items</li>
                                <?php endif; ?>
                            </ul>
                        </td>

                        <td>₱<?= number_format($order['total_amount'], 2); ?></td>
                        <td><?= htmlspecialchars($order['status']); ?></td>
                        <td><?= htmlspecialchars($order['payment_status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No orders found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>