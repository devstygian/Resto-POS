<?php
$conn = new mysqli("localhost", "root", "", "ordering_system");
$order_id = intval($_GET['order_id']);

$result = $conn->query("SELECT product_name, price, quantity FROM order_items WHERE order_id=$order_id");
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
