// BASE_URL points to your 'order' folder
const BASE_URL = "http://localhost/Nadine-system/src/order/";

// View Items button
function viewItems(orderId) {
    fetch(`${BASE_URL}order_details.php?order_id=${orderId}&ajax=1`)
        .then(res => {
            if (!res.ok) throw new Error("Failed to fetch order details.");
            return res.json();
        })
        .then(data => {
            let html = "<ul>";
            data.items.forEach(item => {
                html += `<li>${item.product_name} x${item.quantity} - ₱${item.price}</li>`;
            });
            html += "</ul>";

            document.getElementById('modal-items').innerHTML = html;
            document.getElementById('modal-special-instructions').innerText = data.notes || '-';
            document.getElementById('itemsModal').style.display = 'flex';
        })
        .catch(err => {
            ErrorHandler.show("Could not load the order items. Please try again.", "Load Error");
            console.error("Fetch items error:", err);
        });
}

// Close modal
function closeModal() {
    document.getElementById('itemsModal').style.display = 'none';
}

// Delete Order button
function deleteOrder(orderId) {
    if (!confirm("Are you sure you want to delete this order?")) return;
    fetch(`${BASE_URL}delete_order.php?id=${orderId}`)
        .then(res => {
            if (!res.ok) throw new Error("Failed to delete the order.");
            return res.text();
        })
        .then(msg => {
            alert(msg);
            location.reload();
        })
        .catch(err => {
            ErrorHandler.show("An error occurred while trying to delete the order.", "Delete Error");
            console.error("Delete error:", err);
        });
}

// Update Status dropdown
function updateStatus(orderId, status) {
    fetch(`${BASE_URL}update_status.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: orderId, status: status })
    })
        .then(res => {
            if (!res.ok) throw new Error("Status update failed.");
            return res.text();
        })
        .then(msg => alert(msg))
        .catch(err => {
            ErrorHandler.show("Failed to update the order status. Please check your connection.", "Update Error");
            console.error("Status update error:", err);
        });
}
function updatePaymentStatus(orderID, paymentStatus) {
    fetch(`${BASE_URL}upPayment_status.php`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ id: orderID, payment_status: paymentStatus })
    })
        .then(res => {
            if (!res.ok) throw new Error("Payment status update failed.");
            return res.text();
        })
        .then(data => {console.log(data);
        })
        .catch(err => {
            ErrorHandler.show("Could not update the payment status. Please try again.", "Payment Update Error");
            console.error("Payment status error:", err);
        });
}