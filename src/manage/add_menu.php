<?php
include '../config/config.php';

$menu = $_POST['menu'];
$medium = $_POST['price_medium'];
$large = $_POST['price_large'];

$conn->query("INSERT INTO menu (menu, price_medium, price_large)
VALUES ('$menu','$medium','$large')");

header("Location: menu_management.php");
?>