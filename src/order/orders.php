<?php
include '../config/config.php';
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
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/orders.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">

    <style>
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;

            backdrop-filter: blur(8px);
            padding: 10px 20px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Title */
        .header h1 {
            margin: 0;
        }

        .order-search {
            display: flex;
            align-items: center;
            gap: 10px;
            /* space between label and input */
        }

        /* Input styling */
        .order-search input {
            width: 320px;
            /* adjust if needed */
            padding: 10px 15px;
            font-size: 16px;

            background-color: #ffffffe0;
            border-radius: 50px;
            border: 1px solid #131312;

            outline: none;
            transition: 0.3s ease;
        }

        /* Focus effect */
        .order-search input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
    </style>
</head>

<body>

    <?php include '../include/sidebar.php'; ?>

    <div class="content">

        <div class="header">
            <div class="header-text">
                <h1>Orders management</h1>
                <p>Manage all orders in the system.</p>
            </div>

            <!-- Search Bar -->
            <div class="order-search">
                <h1 lass="search-label" style="font-size: 20px; font-weight: 500; white-space: nowrap;">Search <i class="fa-solid fa-search"></i></h1>
                <input type="text" id="orderSearch" placeholder="Search Customers or Addresses..." onkeyup="searchOrders()">
            </div>
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

        <script src="../../assets/js/orders.js"></script>

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