<?php
include '../src/config/config.php';
checkLogin();

// Return monthly sales for Chart.js
$result = $conn->query("
    SELECT DATE_FORMAT(o.order_date,'%Y-%m') AS month,
           SUM(od.price * od.quantity) AS total
    FROM orderdetail od
    JOIN orders o ON od.orderID = o.orderID
    GROUP BY month
    ORDER BY month
");

$monthlySales = [];
while ($row = $result->fetch_assoc()) {
    $monthlySales[] = $row;
}

echo json_encode($monthlySales);
