<?php
session_start();
header("Content-Type: application/json"); // Ensure response is JSON
include("./config.php");

$response = ["success" => false, "message" => ""]; // Default response

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method", 405);
    }

    // Validate required fields
    if (empty($_POST["user_name"]) || empty($_POST["user_email"]) || empty($_POST["user_password"])) {
        throw new Exception("All fields are required", 400);
    }

    $user_name = trim($_POST["user_name"]);
    $phone_number = trim($_POST["phone_number"]);
    $location = trim($_POST["location"]);
    $user_email = filter_var(trim($_POST["user_email"]), FILTER_SANITIZE_EMAIL);
    $user_password = trim($_POST["user_password"]);

    // Validate email format
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format", 400);
    }

// Ensure only numbers and an optional leading "+"
if (!preg_match("/^\+?[0-9]{10,15}$/", $phone_number)) {
    throw new Exception("Invalid phone number format. Use only numbers and optional leading +", 400);
}

// Remove spaces and unwanted characters
$phone_number = preg_replace("/[^0-9+]/", "", $phone_number);






    // Check password strength (minimum 6 characters)
    if (strlen($user_password) < 6) {
        throw new Exception("Password must be at least 6 characters", 400);
    }

    // Check if email already exists
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        throw new Exception("Email already exists", 409);
    }

    // Check if phone number already exists
    $sql = "SELECT phone_number FROM users WHERE phone_number = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $phone_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); // ✅ Execute before checking

    if ($result && mysqli_num_rows($result) > 0) {
        throw new Exception("Phone number already exists", 409);
    }


    // Check if phone number already exists
    $sql = "SELECT phone_number FROM users WHERE phone_number = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $phone_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Hash the password
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO users (name, email, password, phone_number, location) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $user_name, $user_email, $hashed_password, $phone_number, $location);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error signing up. Try again later.", 500);
    }

    // Success response
    $response["success"] = true;
    $response["message"] = "Registration successful!";
    
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    $response["message"] = $e->getMessage();
}

// Return JSON response
echo json_encode($response);
exit();
?>
