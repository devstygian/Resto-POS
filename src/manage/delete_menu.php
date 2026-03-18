<?php
include '../config/config.php';

$id = $_GET['id'];

$conn->query("DELETE FROM menu WHERE menuID='$id'");

header("Location: menu_management.php");
?>