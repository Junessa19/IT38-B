<?php
$host = "localhost";
$user = "root"; // Change if necessary
$password = "";
$database = "clothing_store";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
