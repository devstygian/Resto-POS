<?php
session_start();
include '../config/config.php';
checkLogin();

// Only allow admin to update payment status
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Access denied']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "ordering_system");
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'], $data['payment_status'])) {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$orderID = intval($data['id']);
$payment_status = $conn->real_escape_string($data['payment_status']);

$conn->query("UPDATE orders SET payment_status='$payment_status' WHERE orderID=$orderID");
echo json_encode(['success' => "Order payment status updated to $payment_status"]);
