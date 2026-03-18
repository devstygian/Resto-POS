<?php
include '../config/config.php';
checkLogin();

// OPTIONAL: admin only
if ($_SESSION['role'] !== 'admin') {
    header("Location: staff.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET fullname = ?, role = ? WHERE id = ?");
    $stmt->bind_param("ssi", $fullname, $role, $id);

    if ($stmt->execute()) {
        header("Location: staff.php");
        exit();
    } else {
        echo "Error updating user";
    }

} else {
    header("Location: staff.php");
    exit();
}