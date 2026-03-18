<?php
include '../config/config.php';

$id = $_POST['menuID'];
$menu = $_POST['menu'];
$medium = $_POST['price_medium'];
$large = $_POST['price_large'];

$conn->query("UPDATE menu
SET menu='$menu',
price_medium='$medium',
price_large='$large'
WHERE menuID='$id'");

header("Location: menu_management.php");
