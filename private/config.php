<?php 
$server = "localhost";
$user = "root";
$password = "";
$db_name = "ecommerce_db";

// Create connection
$conn = mysqli_connect($server, $user, $password, $db_name);
// echo"success";
// Check connection
if (!$conn) {
    echo "Database connection failed. Please try again later.";
}

?>
