<?php
$servername = "localhost";
$username = "root"; // Adjust based on your setup
$password = ""; // Adjust based on your setup
$dbname = "e-commerce"; // Use the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
