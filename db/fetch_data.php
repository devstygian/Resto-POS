<?php
include '../src/config/config.php';
checkLogin();

// Fetch monthly sales by payment_status
$result = $conn->query("
    SELECT DATE_FORMAT(o.order_date, '%Y-%m') AS month,
           SUM(CASE WHEN o.payment_status = 'Paid' THEN oi.price * oi.quantity ELSE 0 END) AS paid_total,
           SUM(CASE WHEN o.payment_status = 'Pending' THEN oi.price * oi.quantity ELSE 0 END) AS pending_total,
           SUM(CASE WHEN o.payment_status = 'Refunded' THEN oi.price * oi.quantity ELSE 0 END) AS refunded_total,
           SUM(oi.price * oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    GROUP BY month
    ORDER BY month
");

$monthlySales = [];
while ($row = $result->fetch_assoc()) {
    $monthlySales[] = $row;
}

echo json_encode($monthlySales);
