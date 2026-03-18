<?php
include '../config/config.php';
checkLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // 🔥 If password is NOT empty → update everything
    if (!empty($password)) {

        // Optional: hash password (recommended)
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET fullname = ?, role = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $fullname, $role, $hashed, $id);
    } else {

        // 🔥 If password is empty → DO NOT update password
        $stmt = $conn->prepare("UPDATE users SET fullname = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $fullname, $role, $id);
    }

    if ($stmt->execute()) {
        header("Location: staff.php");
        exit();
    } else {
        die("Update failed: " . $stmt->error);
    }
}
