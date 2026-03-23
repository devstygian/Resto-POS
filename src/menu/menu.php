<?php include '../config/config.php';
checkLogin();
checkRole(['admin']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/menu.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">
    <style>
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;

            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 20px 20px;

            margin-top: -40px;
            margin-bottom: 20px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Title */
        .header h1 {
            font-size: 2rem;
            margin: 0;
        }

        .menu-search {
            display: flex;
            align-items: center;
            gap: 10px;
            /* space between label and input */
        }

        /* Input styling */
        .menu-search input {
            width: 320px;
            /* adjust if needed */
            padding: 10px 15px;
            font-size: 16px;

            background-color: #ffffffe0;
            border-radius: 50px;
            border: 1px solid #131312;

            outline: none;
            transition: 0.3s ease;
        }

        /* Focus effect */
        .menu-search input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
    </style>
</head>

<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="content">
        <div class="header">
            <h1 style="font-size: 2rem;">Food Menu</h1>

            <!-- Search Bar -->
            <div class="menu-search">
                <h1 class="search-label" style="font-size: 20px; font-weight: 500; white-space: nowrap;">Search <i class="fa-solid fa-search"></i></h1>
                <input type="text" id="menuSearch" placeholder="Search menu..." onkeyup="searchMenu()">
            </div>
        </div>

        <!-- Menu Container -->
        <div class="menu-grid" id="menuContainer">
            <!-- Menu items will be loaded here via AJAX -->
        </div>

        <button class="cart-btn" onclick="openCart()">
            <i class="fa-solid fa-cart-plus"></i> Add(<span id="cart-count">0</span>)
        </button>

    </div>

    <!-- CART SLIDE PANEL -->
    <div id="cartOverlay" class="cart-overlay" onclick="closeCart()"></div>

    <div id="cartPanel" class="cart-panel">
        <h2>Your Cart</h2>

        <!-- Customer Info -->
        <label for="customerName">Full Name:</label>
        <input type="text" id="customerName" placeholder="Enter customer full name" required>

        <label for="customerPhone">Phone Number:</label>
        <input type="number" id="customerPhone" placeholder="+63xx-xxxx-xxxx" limit="11" oninput="this.value = this.value.slice(0, 11)" required>

        <label for="customerAddress">Address:</label>
        <input type="text" id="customerAddress" placeholder="Enter address" required>

        <label for="orderNotes">Notes / Special Requests:</label>
        <textarea id="orderNotes" placeholder="Add any notes or special requests here"></textarea>

        <label for="deliveryType" required>Delivery Type:</label>
        <select id="deliveryType" required>
            <option value="Pickup">Pick Up</option>
            <option value="Delivery">Delivery</option>
        </select>

        <label for="deliveryDateTime">Delivery Date & Time:</label>
        <input type="datetime-local" id="deliveryDateTime">

        <div class="cart-items" id="cart-items"></div>

        <div class="discount-section">
            <label>Discount (%):</label>
            <input type="number" id="discountPercent" min="0" max="100" step="0.01" value="0" style="margin-top: 10%;">
        </div>

        <!-- Calculate totals and checkout-->
        <div class="cart-totals" id="cart-totals"></div>
        <button class="checkout-btn" onclick="checkout()">Checkout</button>
        <button class="back-btn" onclick="closeCart()">Back</button>
    </div>

    <script src="../../assets/js/cart.js"></script>

    <script>
        // AJAX search function
        function searchMenu() {
            const query = document.getElementById('menuSearch').value;

            fetch(`menu_search.php?q=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('menuContainer').innerHTML = data;
                });
        }

        // Load all menu items on page load
        document.addEventListener('DOMContentLoaded', () => {
            searchMenu();
        });
    </script>

</body>

</html>