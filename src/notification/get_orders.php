<?php
include '../config/config.php';

$conn = new mysqli("localhost", "root", "", "ordering_system");

$orders = $conn->query("
    SELECT orderID, customer_name, total_amount, status, order_date, payment_status
    FROM orders 
    ORDER BY order_date DESC
    LIMIT 12
");

if ($orders && $orders->num_rows > 0):
    while ($order = $orders->fetch_assoc()):
        $formatted_date = date("M d, Y h:i A", strtotime($order['order_date']));
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
                <span class="order-date"><?= $formatted_date; ?></span>
            </div>

            <div class="card-items">
                <ul>
                    <?php if ($items_result && $items_result->num_rows > 0): ?>
                        <?php while ($item = $items_result->fetch_assoc()): ?>
                            <li>
                                <span><?= htmlspecialchars($item['product_name']) ?> (x<?= $item['quantity'] ?>)</span>
                                <span>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li>No items</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
<?php
    endwhile;
else:
    echo "<p class='no-orders'>No orders available.</p>";
endif;
