document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu toggle
    const menuToggle = document.getElementById("menuToggle");
    const mobileNav = document.getElementById("mobileNav");

    if (menuToggle) {
        menuToggle.addEventListener("click", function () {
            mobileNav.classList.toggle("show");
        });
    }

    // set active state
    const buttons = document.querySelectorAll(".mobile-icon");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            // Remove active class from all buttons
            buttons.forEach(btn => btn.classList.remove("active"));
            
            // Add active class to the clicked button
            this.classList.add("active");
        });
    });

    // Cart sidebar toggle
    const cartBtn = document.getElementById("cartBtn");
    const cartBtnMobile = document.getElementById("cartBtnMobile");
    const cartContainer = document.getElementById("cartContainer");

    function loadCartSidebar() {
        console.log("Loading cart sidebar..."); // Debugging log
        fetch("../views/cart_sidebar.php")
            .then(response => response.text())
            .then(data => {
                console.log("Cart Sidebar Loaded:", data); // Debugging log
                cartContainer.innerHTML = data;
                cartContainer.style.display = "block"; // Ensure it's visible
            })
            .catch(error => console.error("Error loading cart:", error));
    }
    
    

    if (cartBtn) cartBtn.addEventListener("click", loadCartSidebar);
    if (cartBtnMobile) cartBtnMobile.addEventListener("click", loadCartSidebar);
});
