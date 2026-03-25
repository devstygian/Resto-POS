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
        include 'order_card.php';
    endwhile;
else:
    echo "<p class='no-orders'>No orders available.</p>";
endif;
