<?php
session_start();
include '../private/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$conn->begin_transaction();

try {
    // Fetch cart items
    $cartQuery = "SELECT c.product_id, c.quantity, p.price 
                  FROM cart c 
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = ?";
    $stmt = $conn->prepare($cartQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cartItems = $stmt->get_result();

    if ($cartItems->num_rows === 0) {
        throw new Exception("Your cart is empty.");
    }

    // Insert order without payment details
    $orderQuery = "INSERT INTO orders (user_id, total_price, payment_status) VALUES (?, 0, 'pending')";
    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    $totalPrice = 0;

    while ($row = $cartItems->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $subtotal = $quantity * $price;
        $totalPrice += $subtotal;

        // Insert into order_items
        $orderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($orderItemQuery);
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt->execute();

        // Deduct stock
        $updateStockQuery = "UPDATE products SET stock = stock - ? WHERE id = ?";
        $stmt = $conn->prepare($updateStockQuery);
        $stmt->bind_param("ii", $quantity, $product_id);
        $stmt->execute();
    }

    // Update total price in orders
    $updateOrderQuery = "UPDATE orders SET total_price = ? WHERE id = ?";
    $stmt = $conn->prepare($updateOrderQuery);
    $stmt->bind_param("di", $totalPrice, $order_id);
    $stmt->execute();

    $conn->commit();

    // ✅ Redirect to payment page instead of confirmation
    header("Location: payment.php?order_id=" . $order_id);
    exit;
} catch (Exception $e) {
    $conn->rollback();
    echo "Error processing your order: " . $e->getMessage();
}

$conn->close();
?>
