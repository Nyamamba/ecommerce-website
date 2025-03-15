<?php 
session_start();
include "../private/config.php";

// Check if the product ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product.");
}

$product_id = intval($_GET['id']); // Sanitize input

// Fetch product details from the database
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - Product Details</title>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="stylesheet" href="../public/product.css">
    <link rel="stylesheet" href="../assests/fontawesome/css/all.min.css">
</head>
<body>

       <div class="back-btn-div">
         <button onclick="window.history.back()"><div class="back-arrow">&larr;</div> Back</button>
        </div>

<div class="product-details-container">

    <section class="product-img">
    <img src="../<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    </section>

    <section class="product-second">
    <div class="product-name">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    </div>
    <div class="rating">
    <p> 
        <?php 
        $rating = intval($product['rating']);
        for ($i = 0; $i < 5; $i++) {
            echo $i < $rating ? '<i class="fas fa-star"></i> ' : '<i class="far fa-star"></i> ';
        }
        ?>
    </p>

    <p>5 reviews</p>
    </div>
    <div class="summ-brand">
    <p><?= htmlspecialchars($product['summary']) ?></p>
    <p><b>Brand:</b>  <?= htmlspecialchars($product['brand']) ?></p>
    </div>
    <div class="additional-info">
    <p><b>BENEFITS: </b> <?= htmlspecialchars($product['benefits']) ?></p>
    <p><b>TARGETS: </b> <?= htmlspecialchars($product['targets']) ?></p>
    <p><b>CLINICALLY EFFECTIVE INGREDIENTS: </b> <?= htmlspecialchars($product['clinical_effective_ingredients']) ?></p>
    </div>
    
    <div class="cart-button">
    <div class="cart-quantity"> 
            <div><p>-</p></div>
            <p>1</p>
            <div><p>+</p></div>
    </div>

    <button class="product-button" onclick="addToCart(<?= $product['id'] ?>)">Add to Bag. $<p class="price"><?= number_format($product['price'], 2) ?></p></button>
    </div>
    <p>+ additional shipping fee</p>
    </section>
</div>

<div class="desc">
    <h2>Details:</h2>
    <p><?= htmlspecialchars($product['description']) ?></p>
</div>

<script src="../public/cart.js"></script>

</body>
</html>
