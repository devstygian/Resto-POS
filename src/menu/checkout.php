<?php
$conn = new mysqli("localhost", "root", "", "ordering_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['items']) || count($data['items']) === 0) {
    echo "Cart is empty";
    exit;
}

// Sanitize inputs
$customer_name = htmlspecialchars($data['customer'] ?? 'Walk-in Customer', ENT_QUOTES);
$customer_phone = htmlspecialchars($data['phone'] ?? '', ENT_QUOTES);
$customer_address = htmlspecialchars($data['address'] ?? '', ENT_QUOTES);
$delivery_type = htmlspecialchars($data['delivery_type'] ?? 'Pickup', ENT_QUOTES);
$delivery_datetime = htmlspecialchars($data['delivery_datetime'] ?? null, ENT_QUOTES);
$notes = htmlspecialchars($data['notes'] ?? '', ENT_QUOTES);
$items = $data['items'];
$discount_percent = isset($data['discount_percent']) ? floatval($data['discount_percent']) : 0;

// Validate discount
if ($discount_percent < 0) $discount_percent = 0;
if ($discount_percent > 100) $discount_percent = 100;

$conn->begin_transaction();

try {
    // Calculate subtotal
    $subtotal = 0;
    foreach ($items as $item) {
        $subtotal += $item['price'] * $item['qty'];
    }

    // Calculate discount
    $discount_amount = ($subtotal * $discount_percent) / 100;
    $final_total = $subtotal - $discount_amount;
    if ($final_total < 0) $final_total = 0;

    // Insert into orders table
    $stmt = $conn->prepare("
        INSERT INTO orders 
        (customer_name, phone, address, delivery_type, delivery_datetime, notes, total_amount, discount_percent, discount_amount, order_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param(
        "ssssssddd",
        $customer_name,
        $customer_phone,
        $customer_address,
        $delivery_type,
        $delivery_datetime,
        $notes,
        $final_total,
        $discount_percent,
        $discount_amount
    );
    $stmt->execute();
    $orderID = $stmt->insert_id; // <- updated variable name to match the new primary key

    // Insert each item
    $stmt_item = $conn->prepare("
        INSERT INTO order_items (orderID, product_name, price, quantity) 
        VALUES (?, ?, ?, ?)
    ");

    foreach ($items as $item) {
        $stmt_item->bind_param(
            "isdi",
            $orderID,      // <- foreign key now matches orders.orderID
            $item['name'],
            $item['price'],
            $item['qty']
        );
        $stmt_item->execute();
    }

    $conn->commit();

    echo "Order saved successfully!\n"
        . "Customer: $customer_name\n"
        . "Phone: $customer_phone\n"
        . "Address: $customer_address\n"
        . "Delivery Type: $delivery_type\n"
        . "Delivery Date/Time: $delivery_datetime\n"
        . "Notes: $notes\n"
        . "Subtotal: ₱" . number_format($subtotal, 2) . "\n"
        . "Discount ($discount_percent%): -₱" . number_format($discount_amount, 2) . "\n"
        . "Final Total: ₱" . number_format($final_total, 2);
} catch (Exception $e) {
    $conn->rollback();
    echo "Error saving order: " . $e->getMessage();
}

$conn->close();
