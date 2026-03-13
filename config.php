<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
$conn = new mysqli("localhost", "root", "", "ordering_system");

// Base URL for the project
$base_url = "http://localhost/Nadine-system/";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ===============================
// 🔐 Protect Pages Function
// ===============================
function checkLogin() {
    if (!isset($_SESSION['admins']) || empty($_SESSION['admins'])) {
        header("Location: ../auth/login.php");
        exit();
    }
}

?>