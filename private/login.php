<?php
session_start();
header("Content-Type: application/json"); // Ensure response is JSON
include("../private/config.php");

$response = ["success" => false, "message" => ""]; // Default response

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method", 405);
    }

    // Check if email and password are set
    if (empty($_POST['user_email']) || empty($_POST['user_password'])) {
        throw new Exception("Email and password are required", 400);
    }

    $user_email = filter_var(trim($_POST['user_email']), FILTER_SANITIZE_EMAIL);
    $user_password = trim($_POST['user_password']);

    // Validate email format
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format", 400);
    }

    // Check if the user exists
    $sql = "SELECT id, name, email, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) === 0) {
        throw new Exception("User does not exist", 404);
    }

    $row = mysqli_fetch_assoc($result);

    // Verify password
    if (!password_verify($user_password, $row['password'])) {
        throw new Exception("Invalid password", 401);
    }

    // Set secure session variables
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_name'] = $row['name'];

    // Success response
    $response["success"] = true;
    $response["message"] = "Login successful!";
    $response["redirect"] = "../views/dashboard.php";

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500); // Set HTTP response code
    $response["message"] = $e->getMessage();
}

// Return JSON response
echo json_encode($response);
?>
