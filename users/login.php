// login.php
<?php
session_start();
include "database-user/db.php"; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $_POST["username_or_email"];
    $password = $_POST["password"];

    // Fetch user by username or email
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        // Password is correct, start the session
        $_SESSION["user"] = $user["username"];
        $_SESSION["user_id"] = $user["id"];
        header("Location: user_dashboard.php");
        exit();
    } else {
        echo "Invalid username/email or password.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label for="username_or_email">Username or Email:</label><br>
        <input type="text" name="username_or_email" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Log in</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>
