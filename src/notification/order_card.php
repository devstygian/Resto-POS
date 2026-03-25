<?php
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
                        <span class="item-name">
                            <?= htmlspecialchars($item['product_name']) ?> (x<?= $item['quantity'] ?>)
                        </span>
                        <span class="item-price">
                            ₱<?= number_format($item['price'] * $item['quantity'], 2) ?>
                        </span>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No items</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card-footer">
        <div class="total">
            <span>Total</span>
            <strong>₱<?= number_format($order['total_amount'], 2); ?></strong>
        </div>

        <div class="status-grid">
            <div class="status-item">
                <label>Food Status</label>
                <select onchange="updateStatus(<?= $order['orderID']; ?>, this.value)" class="status-select">
                    <option value="Pending" <?= $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Preparing" <?= $order['status'] === 'Preparing' ? 'selected' : ''; ?>>Preparing</option>
                    <option value="Ready" <?= $order['status'] === 'Ready' ? 'selected' : ''; ?>>Ready</option>
                    <option value="Completed" <?= $order['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="Cancelled" <?= $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>

            <div class="status-item">
                <label>Payment</label>
                <span class="payment-badge <?= strtolower($order['payment_status']); ?>">
                    <?= htmlspecialchars($order['payment_status']); ?>
                </span>
            </div>
        </div>
    </div>
</div>