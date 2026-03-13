<?php include '../config.php';
checkLogin(); ?>

<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../assets/menu.css">
    <link rel="stylesheet" href="../icon/css/all.min.css">
</head>

<body>
    <?php include '../sidebar/sidebar.php'; ?>

    <div class="content">

        <h1>Food Menu</h1>

        <div class="menu-grid">

            <?php
            $result = $conn->query("SELECT * FROM menu");
            while ($row = $result->fetch_assoc()) {
            ?>

                <div class="food-card">

                    <h3><?= $row['menu'] ?></h3>

                    <!-- SIZE SELECT -->
                    <div class="size-select">

                        <label>
                            <input type="radio"
                                name="size<?= $row['menuID'] ?>"
                                value="medium"
                                checked
                                onclick="updatePrice(<?= $row['menuID'] ?>, <?= $row['price_medium'] ?>)">
                            Medium
                        </label>

                        <label>
                            <input type="radio"
                                name="size<?= $row['menuID'] ?>"
                                value="large"
                                onclick="updatePrice(<?= $row['menuID'] ?>, <?= $row['price_large'] ?>)">
                            Large
                        </label>

                    </div>

                    <!-- PRICE + ADD TO CART INLINE -->
                    <div class="card-bottom">
                        <p class="price" id="price<?= $row['menuID'] ?>">
                            ₱<?= $row['price_medium'] ?>
                        </p>
                        <button class="add-btn"
                            onclick="addSelectedToCart(
        <?= $row['menuID'] ?>,
        '<?= $row['menu'] ?>',
        <?= $row['price_medium'] ?>,
        <?= $row['price_large'] ?>
    )">
                            <i class="fa-solid fa-cart-arrow-down"></i> Add
                        </button>
                    </div>

                </div>

            <?php } ?>

        </div>

        <button class="cart-btn" onclick="openCart()"><i class="fa-solid fa-cart-plus"></i> Add(<span id="cart-count">0</span>)</button>

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
            <option value="Door-to-Door">Door-to-Door Delivery</option>
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
</body>

</html>