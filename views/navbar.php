<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get first letter of user's name in uppercase
$userInitial = isset($_SESSION['username']) ? strtoupper($_SESSION['username'][0]) : 'U';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <link rel="stylesheet" href="../public/navbar.css">
    <link rel="stylesheet" href="../public/styles.css">
    <link rel="stylesheet" href="../assests/fontawesome/css/all.min.css">
</head>
<body>
<nav class="navbar">
    <!-- Large Screen Navbar -->
    <section class="large-nav">
        <div class="logo">
            <a href="dashboard.php">MyShop</a>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search products...">
            <i class="fas fa-search"></i> <!-- Search Icon -->
        </div>
        <div class="nav-icons">
            <button id="cartBtn" class="cart-button">
                <i class="fas fa-shopping-cart"></i> <!-- Cart Icon -->
            </button>
            <div class="profile">
                <a href="./profile.php">
                <?php echo $userInitial; ?>
                </a>
                
            </div>
        </div>
    </section>

    <!-- Mobile Navbar -->
    <section id="mobileNav" class="mobile-nav">
        <button id="homeBtn" class="mobile-icon <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
            <a href="dashboard.php">
                <i class="fas fa-home"></i>
            </a>
        </button>
        <button id="searchBtn" class="mobile-icon search-icon">
            <i class="fas fa-search"></i>
        </button>
        <button id="cartBtnMobile" class="mobile-icon <?php echo ($current_page == 'cart.php') ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i>
        </button>
        <button class="mobile-icon <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
            <a href="profile.php">
                <i class="fas fa-user"></i>
            </a>
        </button>
    </section>


    <!-- Hidden Search Bar for Mobile -->
    <div id="mobileSearch" class="mobile-search hidden">
        <input type="text" placeholder="Search products..." class="mobile-search-input">
        <i class="fas fa-search"></i> <!-- Search Icon -->
    </div>
</nav>

<script>
document.getElementById("searchBtn").addEventListener("click", function() {
    let searchBox = document.getElementById("mobileSearch");
    searchBox.classList.toggle("hidden");

    // Auto-focus input when search is opened
    if (!searchBox.classList.contains("hidden")) {
        searchBox.querySelector("input").focus();
    }
});
</script>

<script src="../public/navbar.js"></script>
<script src="../public/cart.js"></script>
</body>
</html>
