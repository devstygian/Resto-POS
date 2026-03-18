<?php
include '../config/config.php';
checkLogin();

// Only allow POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $role = $_POST['role'];

    // 🔐 Hash password (IMPORTANT)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Username already exists!'); window.history.back();</script>";
        exit();
    }

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashedPassword, $fullname, $role);

    if ($stmt->execute()) {
        // Success → redirect back
        header("Location: staff.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    // If accessed directly
    header("Location: staff.php");
    exit();
}
