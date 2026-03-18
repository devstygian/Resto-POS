<?php
$conn = new mysqli("localhost", "root", "", "ordering_system");

// Use orderID instead of id
$orderID = intval($_GET['id']);

$conn->query("DELETE FROM orders WHERE orderID=$orderID");
echo "Order deleted successfully!";
