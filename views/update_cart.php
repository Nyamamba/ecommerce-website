<?php
session_start();
include '../private/config.php';

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

if (!isset($_POST['cart_id']) || !isset($_POST['action'])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_id = $_POST['cart_id'];
$action = $_POST['action'];

// Check if the cart item exists
$checkCart = $conn->prepare("SELECT quantity FROM cart WHERE id = ? AND user_id = ?");
$checkCart->bind_param("ii", $cart_id, $user_id);
$checkCart->execute();
$result = $checkCart->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Cart item not found"]);
    exit;
}

$row = $result->fetch_assoc();
$quantity = $row['quantity'];

if ($action === 'increase') {
    $newQuantity = $quantity + 1;
} elseif ($action === 'decrease') {
    $newQuantity = max(1, $quantity - 1); // Prevent quantity from going below 1
} else {
    echo json_encode(["error" => "Invalid action"]);
    exit;
}

// Update quantity in cart
$updateCart = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
$updateCart->bind_param("ii", $newQuantity, $cart_id);
$updateCart->execute();

echo json_encode(["success" => "Cart updated", "newQuantity" => $newQuantity]);

$conn->close();
?>
