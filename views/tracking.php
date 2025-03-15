<?php
session_start();
include '../private/config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login.php");
    exit;
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

// Fetch tracking details
$trackingQuery = "SELECT status, updated_at FROM tracking WHERE order_id = ?";
$stmt = $conn->prepare($trackingQuery);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$trackingResult = $stmt->get_result();

// Check if tracking data exists
if ($trackingResult->num_rows === 0) {
    echo "Tracking details not found for this order.";
    exit;
}

$tracking = $trackingResult->fetch_assoc();
$currentStatus = $tracking['status'];
$lastUpdated = strtotime($tracking['updated_at'] ?? ''); // Avoid errors if null


// Define tracking statuses
$statuses = ["Pending", "On Route", "Delivered"];
$currentIndex = array_search($currentStatus, $statuses);

// **Update Status Every Minute**
if ($currentIndex < 2) { // Only update if not already "Delivered"
    $timeSinceUpdate = time() - $lastUpdated;
    if ($timeSinceUpdate >= 60) { // 1 minute passed
        $newStatus = $statuses[$currentIndex + 1];
        $updateQuery = "UPDATE tracking SET status = ? WHERE order_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $newStatus, $order_id);
        $updateStmt->execute();
        $currentStatus = $newStatus; // Update displayed status
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Tracking</title>
    <link rel="stylesheet" href="../public/tracking.css">
    <meta http-equiv="refresh" content="60">
</head>
<body>
    <main class="tracking-container">
        <h2>Order Tracking</h2>
        <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($currentStatus); ?></p>
        <p><strong>Last Updated:</strong> <?php echo date("Y-m-d H:i:s"); ?></p>

        <!-- Tracking Timeline -->
        <div class="timeline">
            <div class="step <?php echo ($currentIndex >= 0) ? 'active' : ''; ?>">
                <div class="circle">✔</div>
                <p>Pending</p>
            </div>
            <div class="step <?php echo ($currentIndex >= 1) ? 'active' : ''; ?>">
                <div class="circle">🚚</div>
                <p>On Route</p>
            </div>
            <div class="step <?php echo ($currentIndex >= 2) ? 'active' : ''; ?>">
                <div class="circle">✅</div>
                <p>Delivered</p>
            </div>
        </div>

        <a href="orders.php" class="btn">Back to Orders</a>
    </main>
</body>
</html>
