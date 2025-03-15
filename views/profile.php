<?php
session_start();
include("../private/config.php");

// Check if user is logged in
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header('Location: login.php');
    exit;
}

// get user ID

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, email, phone_number, location  FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt,"i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// check if use exists
if ($user = mysqli_fetch_assoc($result)) {
    $name = htmlspecialchars($user['name']);
    $email = htmlspecialchars($user['email']);
    $phone = htmlspecialchars($user['phone_number']);
    $location = htmlspecialchars($user['location']);
}else {
    $_SESSION['error'] = "User not found";
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Glam: Profile</title>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="stylesheet" href="../public/profile.css">
    <link rel="stylesheet" href="../assests/fontawesome/css/all.min.css">
</head>
<body>
    <div class="profile-container">
        <div class="back-btn-div">
        <button onclick="window.history.back()"><div class="back-arrow">&larr;</div> Back</button>
        </div>
        
        
        <div class="profile-card">
            <img src="../assests/images/image.jpg" alt="Profile Picture" class="profile-pic">
            <h2 class="username"><?php echo $name ?></h2>
            <p class="email"><?php echo $email ?></p>
        </div>
        
        <div class="profile-details">
            <h3>Account Details</h3>
            <p class="user_name"><strong>Full Name:</strong> <?php echo $name ?></p>
            <p><strong>Email:</strong> <?php echo $email ?></p>
            <p><strong>Phone: </strong><?php echo $phone ?></p>
            <p><strong>Address: </strong> <?php echo $location ?></p>
        </div>

        <div class="profile-actions">
            <div class="btn orders-btn">
                <a href="orders.php">
                    <i class="fas fa-history"></i>
                </a>
            </div>
            <div id="cartBtn" class="btn cart-btn">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        
        <button id="logoutButton" class="logout-btn">Logout</button>

        <script src="../public/logout.js"></script>
        <script src="../public/cart.js"></script>
    </div>
</body>
</html>

<?php include 'cart_sidebar_body.php'; ?>