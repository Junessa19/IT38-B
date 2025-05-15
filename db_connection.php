<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'stockhub'; // ⚠️ Change this to your real DB name

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
