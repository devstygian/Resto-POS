<?php include '../config.php';
checkLogin(); ?>

<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../assets/menu.css">
    <link rel="stylesheet" href="../icon/css/all.min.css">
    <style>
        /* Search bar styling */
        .menu-search {
            width: 50%;
            border-radius: 5px;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .menu-search input {
            width: 50%;
            max-width: 500px;
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            background-color: aliceblue;
            border-radius: 500px;
        }

        .food-card {
            display: inline-block;
            /* keep grid display */
            margin: 5px;
        }
    </style>
</head>

<body>
    <?php include '../sidebar/sidebar.php'; ?>

    <div class="content">

        <h1>Food Menu</h1>

        <!-- Search Bar -->
        <div class="menu-search">
            <input type="text" id="menuSearch" placeholder="Search menu..." onkeyup="searchMenu()">
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
        <input type="text" id="customerName" placeholder="Enter customer full name">

        <label for="customerPhone">Phone Number:</label>
        <input type="text" id="customerPhone" placeholder="+63xxxxxxxxxx" value="+63">

        <label for="customerAddress">Address:</label>
        <input type="text" id="customerAddress" placeholder="Enter address">

        <label for="orderNotes">Notes / Special Requests:</label>
        <textarea id="orderNotes" placeholder="Add any notes or special requests here"></textarea>

        <label for="deliveryType">Delivery Type:</label>
        <select id="deliveryType">
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

    <script src="../assets/cart.js?v=2"></script>

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