<?php
$conn = new mysqli("localhost", "root", "", "ordering_system");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// ===== PAGINATION =====
$limit = 5; // orders per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

// total records
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM orders");
$totalRows = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// fetch paginated orders
$orders = $conn->query("
    SELECT orderID, customer_name, total_amount, status, order_date, payment_status
    FROM orders 
    ORDER BY order_date DESC
    LIMIT $limit OFFSET $offset
");
?>
<div class="table-wrapper">
    <div class="orders-container">
        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Items</th>
                        <th>Total (₱)</th>
                        <th>Food Status</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders && $orders->num_rows > 0): ?>
                        <?php while ($order = $orders->fetch_assoc()): ?>
                            <?php
                            $formatted_order_date = date("M d, Y h:i A", strtotime($order['order_date']));
                            $order_id = (int)$order['orderID'];
                            $items_result = $conn->query("SELECT product_name, price, quantity FROM order_items WHERE orderID = $order_id");
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($order['customer_name']); ?></td>
                                <td><?= $formatted_order_date; ?></td>
                                <td class="items-cell">
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
                            <td colspan="6" style="text-align:center;">No orders found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- ===== PAGINATION ===== -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="page-btn">Prev</a>
            <?php else: ?>
                <span class="page-btn disabled">Prev</span>
            <?php endif; ?>

            <span class="page-info"><?= $page ?> of <?= $totalPages ?></span>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="page-btn">Next</a>
            <?php else: ?>
                <span class="page-btn disabled">Next</span>
            <?php endif; ?>
        </div>
    </div>
</div>