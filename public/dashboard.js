document.addEventListener("DOMContentLoaded", function () {
    function filterCategory(category) {
        const products = document.querySelectorAll(".product");
        products.forEach(product => {
            if (category === "all" || product.dataset.category === category) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        });
    }

    window.filterCategory = filterCategory; // Make function global for button clicks
});
