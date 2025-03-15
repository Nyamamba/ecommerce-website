<?php
session_start();
include '../private/config.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Please log in to see your cart.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT c.id AS cart_id, p.name, p.price, c.quantity, p.image_url 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<!-- Cart Items -->
<div class="cart-items">
<?php while ($row = $result->fetch_assoc()): 
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $imagePath = !empty($row['image_url']) ? '../' . htmlspecialchars($row['image_url']) : '../assests/images/landing.png';
?>
    <div class="cart-item">
        <div class="cart-image">
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        </div>
        <div class="cart-item-header">
            <h4><?= htmlspecialchars($row['name']) ?></h4>
            <p class="price">$<?= number_format($row['price'], 2) ?></p>
            <button onclick="removeFromCart(<?= $row['cart_id'] ?>)">Remove</button>
        </div>
        <div class="cart-quantity"> 
            <button onclick="updateCart(<?= $row['cart_id'] ?>, 'decrease')">-</button>
            <?= $row['quantity'] ?>
            <button onclick="updateCart(<?= $row['cart_id'] ?>, 'increase')">+</button>
        </div>
    </div>
<?php endwhile; ?>
</div>

<!-- Cart Footer -->
<div class="cart-footer">
    <h4>Total: $<?= number_format($total, 2) ?></h4>
    <div class="cart-footer-buttons">
        <button onclick="window.location.href='order.php'">Place Order</button>
        <button onclick="window.location.href='orders.php'">Orders</button>
    </div>
</div>
