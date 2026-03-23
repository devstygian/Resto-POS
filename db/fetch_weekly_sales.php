<?php
include '../src/config/config.php';
checkLogin();

// Weekly sales by payment_status
$result = $conn->query("
    SELECT YEAR(o.order_date) AS year,
           WEEK(o.order_date, 1) AS week, 
           SUM(CASE WHEN o.payment_status = 'Paid' THEN oi.price * oi.quantity ELSE 0 END) AS paid_total,
           SUM(CASE WHEN o.payment_status = 'Pending' THEN oi.price * oi.quantity ELSE 0 END) AS pending_total,
           SUM(CASE WHEN o.payment_status = 'Cancelled' THEN oi.price * oi.quantity ELSE 0 END) AS cancelled_total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    GROUP BY year, week
    ORDER BY year, week
");

$weeklySales = [];
while ($row = $result->fetch_assoc()) {
    $weeklySales[] = [
        'label' => 'W' . $row['week'] . ' - ' . $row['year'],
        'paid' => $row['paid_total'],
        'pending' => $row['pending_total'],
        'cancelled' => $row['cancelled_total']
    ];
}

echo json_encode($weeklySales);
