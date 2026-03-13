// BASE_URL points to your 'order' folder
const BASE_URL = "http://localhost/Nadine-system/order/";

// View Items button
function viewItems(orderId) {
    fetch(`${BASE_URL}order_details.php?order_id=${orderId}&ajax=1`)
        .then(res => res.json())
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
        .catch(err => console.error("Error fetching items:", err));
}

// Close modal
function closeModal() {
    document.getElementById('itemsModal').style.display = 'none';
}

// Delete Order button
function deleteOrder(orderId) {
    if (!confirm("Are you sure you want to delete this order?")) return;
    fetch(`${BASE_URL}delete_order.php?id=${orderId}`)
        .then(res => res.text())
        .then(msg => {
            alert(msg);
            location.reload();
        })
        .catch(err => console.error("Error deleting order:", err));
}

// Update Status dropdown
function updateStatus(orderId, status) {
    fetch(`${BASE_URL}update_status.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: orderId, status: status })
    })
        .then(res => res.text())
        .then(msg => alert(msg))
        .catch(err => console.error("Error updating status:", err));
}