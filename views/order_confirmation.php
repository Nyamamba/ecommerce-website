<?php
session_start();
include '../private/config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login.php");
    exit;
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

// Fetch order details
$orderQuery = "SELECT id, created_at AS order_date, total_price FROM orders WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($orderQuery);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$orderResult = $stmt->get_result();

if ($orderResult->num_rows === 0) {
    echo "Order not found.";
    exit;
}

$order = $orderResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../public/confirmation.css">
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <main class="confirmation-container">
    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 512 512" fill="#d81b60">
    <path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zm-288 122.783L409.941 194.86l-28.277-28.277-166.222 166.1-69.253-69.253-28.277 28.277L216 378.783z"/>
</svg>
        <h2>Order Placed Successfully!</h2>
        <p>Your order <strong>#<?php echo $order['id']; ?></strong> has been placed.</p>

        <div class="confirmation-buttons">
            <a href="orders.php" class="btn">View Order</a>
            <a href="dashboard.php" class="btn secondary">Continue Shopping</a>
        </div>
    </main>
</body>
</html>
