<?php 
session_start();

// Check the form type from the URL
$formType = isset($_GET['form']) ? $_GET['form'] : 'login'; // Default to login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($formType); ?> - Aysha's Shop</title>
    <link rel="stylesheet" href="../public/forms.css">
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
<main>
            
                <div id="loginBox" class="form-box" style="<?php echo ($formType === 'login') ? 'display:block;' : 'display:none;'; ?>">
                    <h2 class="form-header">Login</h2>
                    <form id="loginForm">
                        <div class="input-div">
                        <label for="email">Email: </label>
                        <input type="email" name="user_email" required>
                        </div>

                        <div class="input-div">
                        <label for="password">Password: </label>
                        <input type="password" name="user_password" required>
                        </div>

                        <button type="submit" class="submit-buttons">Login</button>
                        <p id="loginError" style="color: red;"></p>
                    </form>
                    <p>Don't have an account? <a href="forms.php?form=register">Register</a></p>
                </div>

                <div id="registerBox" class="form-box" style="<?php echo ($formType === 'register') ? 'display:block;' : 'display:none;'; ?>">
                    <h2 class="form-header">Register</h2>
                    <form id="registerForm">
                    <div class="input-div">
                        <label for="name">Name: </label>
                        <input type="text" name="user_name" required>
                    </div>
                    <div class="input-div">
                        <label for="email">Email: </label>
                        <input type="email" name="user_email" required>
                    </div>
                    <div class="input-div">
                        <label for="phone_number">Phone Number: </label>
                        <input type="text" name="phone_number" required>
                    </div>
                    <div class="input-div">
                        <label for="location">Location: </label>
                        <input type="text" name="location" required>
                    </div>
                    <div class="input-div">
                        <label for="password">Password: </label>
                        <input type="password" name="user_password" required>
                    </div>
                        <button type="submit" class="submit-buttons">Register</button>
                        <p id="registerError" style="color: red;"></p>
                    </form>
                    <p>Already have an account? <a href="forms.php?form=login">Login</a></p>
                </div>

    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loginBox = document.getElementById("loginBox");
            const registerBox = document.getElementById("registerBox");

            // Toggle between login and register forms
            document.getElementById("showRegister")?.addEventListener("click", function () {
                loginBox.style.display = "none";
                registerBox.style.display = "block";
            });

            document.getElementById("showLogin")?.addEventListener("click", function () {
                loginBox.style.display = "block";
                registerBox.style.display = "none";
            });

            // Handle Login Form Submission
            document.getElementById("loginForm").addEventListener("submit", function (event) {
                event.preventDefault(); // Prevent page reload

                let formData = new FormData(this); // Collect form data

                fetch("../private/login.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json()) // Parse JSON response
                .then(data => {
                    if (data.success) {
                        window.location.href = "../views/dashboard.php"; // Redirect if login is successful
                    } else {
                        document.getElementById("loginError").innerText = data.message;
                    }
                })
                .catch(error => console.error("Error:", error));
            });

            // Handle Register Form Submission
            document.getElementById("registerForm").addEventListener("submit", function (event) {
                event.preventDefault();

                let formData = new FormData(this);

                fetch("../private/register.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Registration successful! Redirecting to login...");
                        window.location.href = "forms.php?form=login"; // Redirect to login page
                    } else {
                        document.getElementById("registerError").innerText = data.message;
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        });
    </script>

</body>
</html>
