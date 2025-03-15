<?php
session_start();
include '../private/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$ordersQuery = "SELECT id, created_at, total_price, phone_number, location, status 
                FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($ordersQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="../public/orders.css">
    <link rel="stylesheet" href="../public/style.css">
    <link rel="stylesheet" href="../assests/fontawesome/css/all.min.css">
</head>
<body>
    <main class="orders-container">
       <div class="orders-header">
       <h2>My Orders</h2>
       <div class="search-bar">
            <input type="text" placeholder="Search products...">
            <i class="fas fa-search"></i>
        </div>
       </div>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Phone</th>
                <th>Location</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($order = $orders->fetch_assoc()) { ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo $order['created_at']; ?></td> <!-- FIXED THIS -->
                    <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($order['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($order['location']); ?></td>
                    <td><div class="status"><?php echo htmlspecialchars($order['status']); ?></div></td>
                    <td>
                        <a href="tracking.php?order_id=<?php echo $order['id']; ?>" class="btn">Track Order</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>
