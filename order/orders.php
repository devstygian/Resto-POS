<?php
include '../config.php';
checkLogin();

// Use a single connection
$conn = new mysqli("localhost", "root", "", "ordering_system");

// Fetch all orders (fallback display)
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

    <style>
        /* Search bar styling */
        .order-search {
            border-radius: 5px;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .order-search input {
            width: 50%;
            max-width: 500px;
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            background-color: aliceblue;
            border-radius: 500px;
        }
    </style>
</head>

<body>

    <?php include '../sidebar/sidebar.php'; ?>

    <div class="content">
        <h1>Orders management</h1>
        <p style="margin-bottom: 20px;">Manage all orders in the system.</p>

        <!-- SEARCH BAR -->
        <div class="order-search" style="margin-bottom: 15px; text-align: center;">
            <input type="text" id="orderSearch"
                placeholder="Search customer or address..."
                onkeyup="searchOrders()"
                style="width: 50%; padding: 8px; font-size: 16px;">
        </div>

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

        <script src="../assets/orders.js"></script>
      
        <script>
            function searchOrders() {
                const query = document.getElementById("orderSearch").value;

                fetch("orders_search.php?q=" + encodeURIComponent(query))
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("ordersTableBody").innerHTML = data;
                    })
                    .catch(error => console.error("Error:", error));
            }

            // Load all orders when page loads
            window.onload = searchOrders;
        </script>

    </div>

</body>

</html>