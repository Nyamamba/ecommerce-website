<?php
session_start();
include '../private/config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login.php");
    exit;
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$orderQuery = "SELECT total_price FROM orders WHERE id = ?";
$stmt = $conn->prepare($orderQuery);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Invalid order.";
    exit;
}

$order = $result->fetch_assoc();
$totalPrice = $order['total_price'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone_number = $_POST['phone_number'];
    $location = $_POST['location'];

    // Validate inputs
    if (empty($phone_number) || empty($location)) {
        echo "Please enter your phone number and location.";
    } else {
       // ✅ Update the order with payment details
        $updateOrder = "UPDATE orders SET phone_number = ?, location = ?, payment_status = 'paid' WHERE id = ?";
        $stmt = $conn->prepare($updateOrder);
        $stmt->bind_param("ssi", $phone_number, $location, $order_id);
        $stmt->execute();

        // ✅ Insert tracking only if payment is confirmed
        $trackingQuery = "INSERT INTO tracking (order_id, status) VALUES (?, 'Pending')";
        $stmt = $conn->prepare($trackingQuery);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        // ✅ Clear the cart after successful payment
        $clearCartQuery = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($clearCartQuery);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();

        // ✅ Redirect to order confirmation
        header("Location: order_confirmation.php?order_id=" . $order_id);
        exit;

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/forms.css">
    <link rel="stylesheet" href="../public/style.css">
    <title>Payment</title>
</head>
<body>
    <main>
    <h2>Complete Your Payment</h2>
    <form method="post" class="form-box">
    <div class="input-div">
    <label for="phone_number">Phone Number:</label>
    <input type="text" name="phone_number" required>
    </div>

    <div class="input-div">
    <label for="location">Location:</label>
    <input type="text" name="location" required>
    </div>

    <div class="payment-price-back">
    <button type="button" onclick="window.history.back();"><span class="back-arrow">←</span> Back</button>
    <p>Total Amount: <strong class="price">$<?php echo number_format($totalPrice, 2); ?></strong></p>
    </div>
    <button type="submit" class="submit-buttons">Confirm Payment</button>
    </main>
</form>

</body>
</html>
