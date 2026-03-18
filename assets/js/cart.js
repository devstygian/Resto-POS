let cart = [];

// Add item to cart
function addToCart(id, name, price) {
    let existing = cart.find(item => item.id === id);

    if (existing) {
        existing.qty++;
    } else {
        cart.push({ id, name, price, qty: 1 });
    }

    updateCart();
}

// Update price display when size changes
function updatePrice(id, price) {
    document.getElementById("price" + id).innerText = "₱" + price;
}

// Add selected size to cart
function addSelectedToCart(id, name, mediumPrice, largePrice) {

    let size = document.querySelector('input[name="size' + id + '"]:checked').value;

    let price = size === "medium" ? mediumPrice : largePrice;

    let itemName = name + " (" + size + ")";

    // Make unique ID for size
    let uniqueId = id + "_" + size;

    addToCart(uniqueId, itemName, price);
}

// Update cart display
function updateCart() {

    const cartCountEl = document.getElementById("cart-count");
    const cartItemsEl = document.getElementById("cart-items");
    const cartTotalsEl = document.getElementById("cart-totals");
    const discountInput = document.getElementById("discountPercent");

    if (!cartCountEl || !cartItemsEl || !cartTotalsEl || !discountInput) return;

    // Calculate total quantity
    let totalQty = cart.reduce((total, item) => total + item.qty, 0);

    cartCountEl.innerText = totalQty;

    let itemsHTML = "";
    let subtotal = 0;

    cart.forEach((item, index) => {

        subtotal += item.price * item.qty;

        itemsHTML += `
        <div class="cart-item">
            <div>
                ${item.name} x${item.qty}<br>
                ₱${(item.price * item.qty).toFixed(2)}
            </div>

            <button class="delete-btn" onclick="removeItem(${index})">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
        `;
    });

    cartItemsEl.innerHTML = itemsHTML;

    // Discount calculation
    let discountPercent = parseFloat(discountInput.value) || 0;

    if (discountPercent < 0) discountPercent = 0;
    if (discountPercent > 100) discountPercent = 100;

    let discountAmount = (subtotal * discountPercent) / 100;

    let finalTotal = subtotal - discountAmount;

    if (finalTotal < 0) finalTotal = 0;

    cartTotalsEl.innerHTML = `
        <p>Subtotal: ₱${subtotal.toFixed(2)}</p>
        <p>Discount (${discountPercent}%): -₱${discountAmount.toFixed(2)}</p>
        <p><strong>Final Total: ₱${finalTotal.toFixed(2)}</strong></p>
    `;
}

// Remove item
function removeItem(index) {
    cart.splice(index, 1);
    updateCart();
}

// Open cart
function openCart() {

    const overlay = document.getElementById("cartOverlay");
    const panel = document.getElementById("cartPanel");

    if (overlay && panel) {
        overlay.style.display = "block";
        panel.classList.add("open");
    }
}

// Close cart
function closeCart() {

    const overlay = document.getElementById("cartOverlay");
    const panel = document.getElementById("cartPanel");

    if (overlay && panel) {
        overlay.style.display = "none";
        panel.classList.remove("open");
    }
}

// Listen for discount change
document.addEventListener("DOMContentLoaded", () => {

    const discountInput = document.getElementById("discountPercent");

    if (discountInput) {
        discountInput.addEventListener("input", updateCart);
    }

});

// Checkout
function checkout() {

    if (cart.length === 0) {
        alert("Cart is empty!");
        return;
    }

    const customerName = document.getElementById("customerName")?.value || "Walk-in Customer";
    const customerPhone = document.getElementById("customerPhone")?.value || "";
    const customerAddress = document.getElementById("customerAddress")?.value || "";
    const deliveryType = document.getElementById("deliveryType")?.value || "Pickup";
    const deliveryDateTime = document.getElementById("deliveryDateTime")?.value || null;
    const notes = document.getElementById("orderNotes")?.value || "";
    const discountPercent = parseFloat(document.getElementById("discountPercent")?.value) || 0;

    fetch('checkout.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            customer: customerName,
            phone: customerPhone,
            address: customerAddress,
            delivery_type: deliveryType,
            delivery_datetime: deliveryDateTime,
            notes: notes,
            items: cart,
            discount_percent: discountPercent
        })
    })

        .then(res => res.text())

        .then(response => {

            alert(response);

            cart = [];

            document.getElementById("discountPercent").value = 0;

            updateCart();

            closeCart();
        })

        .catch(err => {

            alert("Error: " + err);

        });
}

// Admin: update order status
function updateStatus(orderId, status) {

    fetch('update_status.php', {

        method: 'POST',

        headers: { 'Content-Type': 'application/json' },

        body: JSON.stringify({ id: orderId, status: status })

    })

        .then(res => res.text())

        .then(msg => alert(msg));

}