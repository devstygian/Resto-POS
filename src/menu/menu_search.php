<?php
include '../config/config.php';

$search = $_GET['q'] ?? '';

// Fetch menu items from DB matching the search query
$stmt = $conn->prepare("SELECT * FROM menu WHERE menu LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <div class="food-card">
            <h3><?= $row['menu'] ?></h3>

            <div class="size-select">
                <label>
                    <input type="radio" name="size<?= $row['menuID'] ?>" value="medium" checked
                        onclick="updatePrice(<?= $row['menuID'] ?>, <?= $row['price_medium'] ?>)">
                    Medium
                </label>
                <label>
                    <input type="radio" name="size<?= $row['menuID'] ?>" value="large"
                        onclick="updatePrice(<?= $row['menuID'] ?>, <?= $row['price_large'] ?>)">
                    Large
                </label>
            </div>

            <div class="card-bottom">
                <p class="price" id="price<?= $row['menuID'] ?>">₱<?= $row['price_medium'] ?></p>
                <button class="add-btn"
                    onclick="addSelectedToCart(<?= $row['menuID'] ?>, '<?= $row['menu'] ?>', <?= $row['price_medium'] ?>, <?= $row['price_large'] ?>)">
                    <i class="fa-solid fa-cart-arrow-down"></i> Add
                </button>
            </div>
        </div>
<?php
    }
} else {
    echo "<div>No items found</div>";
}
