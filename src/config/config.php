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
function checkLogin() {
    global $base_url;
    if (!isset($_SESSION['users']) || empty($_SESSION['users'])) {
        header("Location: {$base_url}auth/login.php");
        exit();
    }
}
function checkRole($roles = [])
{
    global $base_url;

    if (!is_array($roles)) {
        $roles = explode(',', $roles);
    }

    $roles = array_map('trim', $roles);

    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $roles, true)) {
        header("Location: {$base_url}auth/unauthorized.php");
        exit();
    }
}
?>