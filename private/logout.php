<?php
session_start();
header("Content-Type: application/json"); // Ensure response is JSON

try {
    // Unset all session variables
    $_SESSION = [];

    // Destroy session
    session_destroy();

    // Success response for AJAX
    echo json_encode(["success" => true, "message" => "Logout successful"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Logout failed. Please try again."]);
}
?>
