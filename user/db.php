<?php
$conn = new mysqli("localhost", "root", "", "stockhub");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
