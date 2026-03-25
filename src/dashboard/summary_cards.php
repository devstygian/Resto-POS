<?php
// ===== GET FILTER SELECTION =====
$filter = $_GET['filter'] ?? 'all_time';
$selectedDate = $_GET['summary_date'] ?? date('Y-m-d');

// ===== DETERMINE DATE RANGE BASED ON SELECTION =====
if ($filter === 'all_time') {
    $startDate = '2000-01-01'; // or your earliest order date
    $endDate   = date('Y-m-d'); // today
} elseif ($filter === 'current_date') {
    $startDate = $endDate = date('Y-m-d');
} elseif ($filter === 'weekdays') {
    $startDate = date('Y-m-d', strtotime('monday this week'));
    $endDate   = date('Y-m-d', strtotime('friday this week'));
} elseif ($filter === 'weekend') {
    $startDate = date('Y-m-d', strtotime('saturday this week'));
    $endDate   = date('Y-m-d', strtotime('sunday this week'));
} elseif ($filter === 'specific_date') {
    $startDate = $endDate = $selectedDate;
}

// ===== QUERY TOTALS BASED ON DATE RANGE =====
$total_amount = $conn->query("
    SELECT SUM(oi.price * oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.order_date) BETWEEN '$startDate' AND '$endDate'
      AND o.payment_status = 'Paid'
")->fetch_assoc()['total'] ?? 0;

$totalOrders = $conn->query("
    SELECT COUNT(*) AS count
    FROM orders
    WHERE DATE(order_date) BETWEEN '$startDate' AND '$endDate'
      AND payment_status = 'Paid'
")->fetch_assoc()['count'] ?? 0;

$totalCustomers = $conn->query("
    SELECT COUNT(DISTINCT customer_name) AS count
    FROM orders
    WHERE DATE(order_date) BETWEEN '$startDate' AND '$endDate'
      AND payment_status = 'Paid'
")->fetch_assoc()['count'] ?? 0;

$totalItems = $conn->query("
    SELECT SUM(oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.order_date) BETWEEN '$startDate' AND '$endDate'
      AND o.payment_status = 'Paid'
")->fetch_assoc()['total'] ?? 0;

// ===== TODAY'S SALES/ORDERS =====
$todaySales = $conn->query("
    SELECT SUM(oi.price * oi.quantity) AS total
    FROM order_items oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE DATE(o.order_date) = CURDATE()
      AND o.payment_status = 'Paid'
")->fetch_assoc()['total'] ?? 0;

$todayOrders = $conn->query("
    SELECT COUNT(*) AS count
    FROM orders
    WHERE DATE(order_date) = CURDATE()
      AND payment_status = 'Paid'
")->fetch_assoc()['count'] ?? 0;
?>

<!-- ===== ENHANCED DATE PICKER + DROPDOWN FORM ===== -->

<?php if ($_SESSION['role'] === 'admin'): ?>
    <div class="filter-container">
        <form method="GET" class="date-filter-form">
            <div class="filter-group">
                <label for="filter">Filter:</label>
                <select name="filter" id="filter" onchange="toggleDatePicker()">
                    <option value="all_time" <?= $filter === 'all_time' ? 'selected' : '' ?>>Overall</option>
                    <option value="current_date" <?= $filter === 'current_date' ? 'selected' : '' ?>>Current Date</option>
                    <option value="weekdays" <?= $filter === 'weekdays' ? 'selected' : '' ?>>Weekdays (Mon-Fri)</option>
                    <option value="weekend" <?= $filter === 'weekend' ? 'selected' : '' ?>>Weekend (Sat-Sun)</option>
                    <option value="specific_date" <?= $filter === 'specific_date' ? 'selected' : '' ?>>Specific Date</option>
                </select>
            </div>

            <div class="filter-group">
                <input type="date" name="summary_date" id="summary_date" value="<?= htmlspecialchars($selectedDate) ?>" style="<?= $filter === 'specific_date' ? '' : 'display:none;' ?>">
            </div>

            <div class="filter-actions">
                <button type="submit">Filter</button>
                <button type="button" class="reset-btn" onclick="resetFilter()">Reset</button>
            </div>
        </form>
    </div>
<?php endif; ?>
<!-- ===== SUMMARY CARDS ===== -->
<div class="cards">
    <!-- Overall / Filtered Summary -->
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
        <div class="card-icon orders"><i class="fas fa-box"></i></div>
        <div>
            <h3>Total Items Sold</h3>
            <h2><?= $totalItems ?></h2>
        </div>
    </div>

    <!-- Today’s Sales / Orders -->
    <div class="card">
        <div class="card-icon today"><i class="fas fa-calendar-day"></i></div>
        <div>
            <h3>Today's Sales</h3>
            <h2>₱<?= number_format($todaySales, 2) ?></h2>
        </div>
    </div>

    <div class="card">
        <div class="card-icon today"><i class="fas fa-receipt"></i></div>
        <div>
            <h3>Today's Orders</h3>
            <h2><?= $todayOrders ?></h2>
        </div>
    </div>
</div>

<!-- ===== JAVASCRIPT ===== -->
<script>
    function toggleDatePicker() {
        const filter = document.getElementById('filter').value;
        const dateInput = document.getElementById('summary_date');
        dateInput.style.display = filter === 'specific_date' ? 'inline-block' : 'none';
    }

    // Reset filter to default (Overall)
    function resetFilter() {
        document.getElementById('filter').value = 'all_time';
        document.getElementById('summary_date').value = '<?= date('Y-m-d') ?>';
        document.getElementById('summary_date').style.display = 'none';
        document.querySelector('.date-filter-form').submit();
    }
</script>