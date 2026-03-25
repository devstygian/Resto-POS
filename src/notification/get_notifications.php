<?php
ob_start();
include '../config/config.php';
/*
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    ob_end_clean();
    echo json_encode(['count' => 0]);
    exit;
}
*/
header('Content-Type: application/json');

// Total pending
$total = $conn->query("
    SELECT COUNT(*) as c 
    FROM orders 
    WHERE status = 'Pending'
")->fetch_assoc()['c'] ?? 0;

// Today's pending (FIXED COLUMN)
$today = $conn->query("
    SELECT COUNT(*) as c 
    FROM orders 
    WHERE status = 'Pending' 
    AND DATE(order_date) = CURDATE()
")->fetch_assoc()['c'] ?? 0;

ob_end_clean();
echo json_encode([
    'count' => (int)$total,
    'today_orders' => (int)$today,
    'advance_orders' => (int)($total - $today)
]);
