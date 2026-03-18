<?php
include 'src/config/config.php';
checkLogin();

/* TOTAL SALES */
$total_amount = $conn->query("
    SELECT SUM(od.price * od.quantity) AS total
    FROM orderdetail od
")->fetch_assoc()['total'] ?? 0;

/* TOTAL ORDERS */
$totalOrders = $conn->query("
    SELECT COUNT(DISTINCT orderID) AS count
    FROM orderdetail
")->fetch_assoc()['count'] ?? 0;

/* TOTAL CUSTOMERS */
$totalCustomers = $conn->query("
    SELECT COUNT(DISTINCT customer_name) AS count
    FROM orders
")->fetch_assoc()['count'] ?? 0;

/* TODAY SALES */
$todaySales = $conn->query("
    SELECT SUM(od.price * od.quantity) AS total
    FROM orderdetail od
    JOIN orders o ON od.orderID = o.orderID
    WHERE DATE(o.order_date) = CURDATE()
")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php include 'src/include/sidebar.php'; ?>

    <div class="content">
        <!-- TOPBAR -->
        <div class="topbar">
            <button id="sidebar-toggle"><i class="fas fa-bars"></i></button>
            <h1>Dashboard</h1>
            <p>Welcome, <?= isset($_SESSION['users']) ? $_SESSION['users'] : 'Guest' ?></p>
        </div>

        <!-- STAT CARDS -->
        <div class="cards">
            <div class="card">
                <div class="card-icon sales"><i class="fas fa-coins"></i></div>
                <div>
                    <h3>Total Sales</h3>
                    <h2>₱<?= number_format($total_amount, 2) ?></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-icon orders"><i class="fas fa-shopping-cart"></i></div>
                <div>
                    <h3>Total Orders</h3>
                    <h2><?= $totalOrders ?></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-icon customers"><i class="fas fa-users"></i></div>
                <div>
                    <h3>Total Customers</h3>
                    <h2><?= $totalCustomers ?></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-icon today"><i class="fas fa-calendar-day"></i></div>
                <div>
                    <h3>Today's Sales</h3>
                    <h2>₱<?= number_format($todaySales, 2) ?></h2>
                </div>
            </div>
        </div>

        <!-- MONTHLY SALES CHART -->
        <div class="card chart-card">
            <div class="card-header">
                <h3>Monthly Sales Overview</h3>
            </div>
            <div class="chart-container">
                <canvas id="chart"></canvas>
            </div>
        </div>

        <!-- RECENT ORDERS -->
        <div class="card">
            <h3>Recent Orders</h3>
            <table>
                <tr>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                </tr>

                <?php
                $result = $conn->query("
            SELECT o.orderID, o.customer_name, o.order_date, SUM(od.price * od.quantity) AS total
            FROM orders o
            JOIN orderdetail od ON o.orderID = od.orderID
            GROUP BY o.orderID
            ORDER BY o.order_date DESC
            LIMIT 5
        ");

                while ($row = $result->fetch_assoc()) {
                    // Get items for this order
                    $items_result = $conn->query("
                SELECT m.menu, od.size, od.quantity
                FROM orderdetail od
                JOIN menu m ON od.menuID = m.menuID
                WHERE od.orderID = {$row['orderID']}
            ");
                    $items_list = [];
                    while ($item = $items_result->fetch_assoc()) {
                        $items_list[] = "{$item['menu']} ({$item['size']}) x{$item['quantity']}";
                    }
                    $items_text = implode(", ", $items_list);

                    echo "
                <tr>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['order_date']}</td>
                    <td>{$items_text}</td>
                    <td>₱" . number_format($row['total'], 2) . "</td>
                </tr>
            ";
                }
                ?>
            </table>
        </div>
        <script src="assets/js/jscript.js"></script>
        <script>
            // Sidebar toggle
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            toggleBtn.addEventListener('click', () => sidebar.classList.toggle('show'));

            // Fetch monthly sales for Chart.js
            fetch('db/fetch_data.php')
                .then(res => res.json())
                .then(data => {
                    const labels = data.map(item => item.month);
                    const totals = data.map(item => item.total);

                    new Chart(document.getElementById('chart'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Monthly Sales',
                                data: totals,
                                backgroundColor: 'rgba(37, 99, 235, 0.2)',
                                borderColor: 'rgba(37, 99, 235, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        </script>

</body>

</html>