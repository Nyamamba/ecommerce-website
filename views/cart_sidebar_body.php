<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/cart.css">
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>

<!-- Cart Overlay -->
<div id="cartOverlay" class="cart-overlay" onclick="closeCart()"></div>

<!-- Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
    <h3>My Cart</h3>
    <button class="close-btn" onclick="closeCart()">X</button>
    </div>
    
    <div id="cartItems" class="cart_items">
        <!-- Cart items will be dynamically loaded here -->
    </div>
</div>

<script src="../public/cart.js"></script>
</body>
</html>
