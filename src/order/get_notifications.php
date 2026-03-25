<?php
ob_start();
include '../../config/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    ob_end_clean();
    echo json_encode(['count' => 0]);
    exit;
}

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "ordering_system");

// ALL PENDING ORDERS (today + advance)
$count = $conn->query("
    SELECT COUNT(*) as count 
    FROM orders 
    WHERE status = 'Pending'
")->fetch_assoc()['count'] ?? 0;

ob_end_clean();
echo json_encode([
    'count' => (int)$count,
    'today_orders' => $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='Pending' AND DATE(today)=CURDATE()")->fetch_assoc()['c'] ?? 0,
    'advance_orders' => $count - ($conn->query("SELECT COUNT(*) as c FROM orders WHERE status='Pending' AND DATE(today)=CURDATE()")->fetch_assoc()['c'] ?? 0)
]);
