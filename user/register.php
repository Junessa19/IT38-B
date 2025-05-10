<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password != password_hash($confirm_password, PASSWORD_DEFAULT)) {
        echo "Passwords do not match!";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, first_name, last_name, email, password, confirm_password) VALUES (?, ?, ?, ?, ?, ?)");
    
    try {
        $stmt->execute([$username, $first_name, $last_name, $email, $password, $confirm_password]);
        header("Location: login.php");
    } catch (Exception $e) {
        echo "Error: Username or email already exists!";
    }
}
?>

<form method="POST">
    <h2>Register</h2>
    Username: <input type="text" name="username" required><br>
    First Name: <input type="text" name="first_name" required><br>
    Last Name: <input type="text" name="last_name" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    Confirm Password: <input type="password" name="confirm_password" required><br>
    <button type="submit">Register</button>
</form>
