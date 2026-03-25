<?php
$conn = new mysqli("localhost", "root", "", "ordering_system");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'], $data['status'])) {
    echo "Invalid request";
    exit;
}

// Use orderID instead of id
$orderID = intval($data['id']);
$status = $conn->real_escape_string($data['status']);

$conn->query("UPDATE orders SET status='$status' WHERE orderID=$orderID");
echo "Order status updated to $status";
