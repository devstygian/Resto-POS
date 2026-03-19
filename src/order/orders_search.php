<?php
include '../config/config.php';  // Make sure $conn is defined here

$search = $_GET['q'] ?? '';

// Prevent SQL injection
$search_safe = $conn->real_escape_string($search);

$query = "
    SELECT orderID, customer_name, total_amount, status, order_date, delivery_datetime, address, delivery_type, notes 
    FROM orders 
    WHERE customer_name LIKE '%$search_safe%' 
       OR address LIKE '%$search_safe%' 
    ORDER BY order_date DESC
";

$result = $conn->query($query);

if (!$result) {
    echo "<tr><td colspan='8'>Query error: " . $conn->error . "</td></tr>";
    exit;
}

if ($result->num_rows > 0):
    while ($order = $result->fetch_assoc()):
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
            <td>
                <select onchange="updateStatus(<?= $order['orderID']; ?>, this.value)" class="status-select">
                    <option value="Pending" <?= $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Completed" <?= $order['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="Cancelled" <?= $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </td>
            <td>
                <button class="action-btn view-btn" onclick="viewItems(<?= $order['orderID']; ?>)">View Items</button>
                <button class="action-btn delete-btn" onclick="deleteOrder(<?= $order['orderID']; ?>)">Delete</button>
            </td>
        </tr>
<?php
    endwhile;
else:
    echo "<tr><td colspan='8'>No orders found</td></tr>";
endif;
?>