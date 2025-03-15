// cart.js - Handles all cart operations
document.addEventListener("DOMContentLoaded", function () {
    const cartBtn = document.getElementById("cartBtn");
    const cartBtnMobile = document.getElementById("cartBtnMobile");
    const cartSidebar = document.getElementById("cartSidebar");
    const cartOverlay = document.getElementById("cartOverlay");
    const closeBtn = document.querySelector(".close-btn");

    if (!cartSidebar || !cartOverlay) {
        console.error("Cart sidebar or overlay not found!");
        return;
    }

    // Open Cart
    function openCart() {
        console.log("Opening cart...");
        cartSidebar.classList.add("show");
        cartOverlay.style.display = "block";
    }

    // Close Cart
    function closeCart() {
        console.log("Closing cart...");
        cartSidebar.classList.remove("show");
        cartOverlay.style.display = "none";
    }

    // Attach event listeners
    if (cartBtn) cartBtn.addEventListener("click", openCart);
    if (cartBtnMobile) cartBtnMobile.addEventListener("click", openCart);
    if (closeBtn) closeBtn.addEventListener("click", closeCart);
    if (cartOverlay) cartOverlay.addEventListener("click", closeCart);

    // Expose closeCart globally
    window.closeCart = closeCart;
});


// Function to add items to the cart
function addToCart(productId) {
    fetch("cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `product_id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.success || data.error);
        loadCart(); // Reload cart
    })
    .catch(error => console.error("Error:", error));
}


// Function to fetch and display cart items in sidebar
function loadCart() {
    fetch("cart_sidebar.php")  // Fetch only cart items
    .then(response => response.text())
    .then(html => {
        let cartItems = document.getElementById("cartItems"); 
        if (!cartItems) {
            console.error("Error: cartItems div not found in the DOM.");
            return;
        }
        cartItems.innerHTML = html;
    })
    .catch(error => console.error("Error loading cart:", error));
}

// Load cart on page load (Only if cart sidebar exists)
document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("cartSidebar")) {
        loadCart();
    }
});


// Function to update item quantity in cart
function updateCart(cartId, action) {
    console.log(`Updating cart item ${cartId} with action: ${action}`);
    fetch("../views/update_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `cart_id=${cartId}&action=${action}`
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Log the response from the server
        if (data.success) {
            loadCart();
        } else {
            alert(data.error);
        }
    })
    .catch(error => console.error("Error updating cart:", error));
}

// Function to remove item from cart
function removeFromCart(cartId) {
    console.log(`Removing cart item: ${cartId}`);
    fetch("../views/remove_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `cart_id=${cartId}`
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Log the response from the server
        if (data.success) {
            loadCart();
        } else {
            alert(data.error);
        }
    })
    .catch(error => console.error("Error removing cart item:", error));
}



// Load cart on page load
document.addEventListener("DOMContentLoaded", loadCart);
