<?php
$host = "localhost";
$user = "root"; // Change if needed
$password = "";
$database = "patabang";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
