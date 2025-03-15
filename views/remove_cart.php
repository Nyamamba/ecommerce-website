<?php
session_start();
include '../private/config.php';

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

if (!isset($_POST['cart_id'])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_id = $_POST['cart_id'];

// Delete cart item
$deleteCart = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$deleteCart->bind_param("ii", $cart_id, $user_id);
$deleteCart->execute();

if ($deleteCart->affected_rows > 0) {
    echo json_encode(["success" => "Item removed from cart"]);
} else {
    echo json_encode(["error" => "Failed to remove item"]);
}

$conn->close();
?>
