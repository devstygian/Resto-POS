<?php
include '../config/config.php';
checkLogin();
checkRole(['admin', 'staff']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/stats.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        
    </style>
</head>

<body>

    <?php include '../include/sidebar.php'; ?>



    <div class="content">
        <div class="header">
            <!-- TOPBAR -->
            <div class="topbar">
               
                <h1>Analytics Report</h1>
                <p>
                    Welcome, <?= $_SESSION['users'] ?? 'Guest' ?>
                    (<?= $_SESSION['role'] ?? 'Unknown' ?>)
                    <i class="fas fa-user-circle"></i>
                </p>
            </div>
            <!-- CHARTS SIDE BY SIDE -->
            <div class="charts-row">
                <!-- MONTHLY CHART -->
                <div class="chart-wrapper">
                    <h3>Monthly Sales</h3>
                    <?php include 'monthly_sales.php'; ?>
                </div>

                <!-- WEEKLY CHART -->
                <div class="chart-wrapper">
                    <h3>Weekly Sales</h3>
                    <?php include 'weekly_sales.php'; ?>
                </div>
            </div>

            <script>
                // Optional: Add smooth animations to charts if not already in your monthly/weekly scripts
                Chart.defaults.animation.duration = 1000;
            </script>

</body>

</html>