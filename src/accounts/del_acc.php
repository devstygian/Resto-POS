<?php
include '../config/config.php';
checkLogin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../acc_management/staff.php");
        exit();
    } else {
        echo "Error deleting user";
    }
} else {
    header("Location: ../acc_management/staff.php");
    exit();
}
