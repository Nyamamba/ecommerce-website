<?php 
session_start();
include "../private/config.php";

// Check if user is logged in
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header('Location: login.php');
    exit;
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aysha's Shop</title>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="stylesheet" href="../public/dashboard.css">
</head>
<body>

    <?php
    $current_page = basename($_SERVER['PHP_SELF']); // Get current filename
    ?>

    <?php include 'navbar.php'; ?>

   <main class="main-dashboard">
        <!-- Product Display Section -->
        <div id="productContainer" class="products">
            <?php foreach ($products as $product): ?>
                <div class="product" data-category="<?= htmlspecialchars($product['category']) ?>">
                    <div class="product-image">
                    <img src="../<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    <div class="product-details">
                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="price"><span class="dollar-sign">$</span> <?= number_format($product['price'], 2) ?></p>
                        </div>
                        <div class="product-buttons">
                            <button onclick="window.location.href='product_page.php?id=<?= $product['id'] ?>'">View</button>
                            <button onclick="addToCart(<?= $product['id'] ?>)">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
</div>

   </main>

    <?php include 'cart_sidebar_body.php'; ?>

    <!-- ✅ Ensure scripts are included -->
    <script src="../public/cart.js"></script>       <!-- ✅ Add missing cart.js -->
    <script src="../public/logout.js"></script>
    <script src="../public/dashboard.js"></script>  <!-- ✅ Ensure dashboard.js is linked -->
</body>
</html>
