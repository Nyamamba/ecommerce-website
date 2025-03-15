<?php
session_start();
include '../private/config.php';

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

// Check if the product is already in the cart
$checkCart = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
$checkCart->bind_param("ii", $user_id, $product_id);
$checkCart->execute();
$result = $checkCart->get_result();

if ($result->num_rows > 0) {
    // If it exists, increase the quantity
    $row = $result->fetch_assoc();
    $cart_id = $row['id'];
    $updateCart = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ?");
    $updateCart->bind_param("i", $cart_id);
    $updateCart->execute();
    echo json_encode(["success" => "Item quantity updated"]);
} else {
    // Otherwise, insert a new row
    $insertCart = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $insertCart->bind_param("ii", $user_id, $product_id);
    $insertCart->execute();
    echo json_encode(["success" => "Item added to cart"]);
}

$conn->close();
?>
