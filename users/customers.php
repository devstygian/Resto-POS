<?php include '../config.php';
checkLogin(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Customers</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../icon/css/all.min.css">
</head>

<body>
    <?php include '../sidebar/sidebar.php'; ?>
    <div class="content">
        <h1>Customer List</h1>
        <p style="margin-bottom: 20px;">View all customers who have placed orders.</p>

        <div class="orders-container">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM customers");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                  </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>