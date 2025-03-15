document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.getElementById("logoutButton");

    if (logoutButton) {
        logoutButton.addEventListener("click", function () {
            fetch("../private/logout.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "../views/forms.php?form=login"; // Redirect to login form
                } else {
                    alert("Logout failed! Please try again.");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    }
});
