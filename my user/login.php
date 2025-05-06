<?php
session_start();
include('db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query database for user data
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on user role
        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");  // Admin Dashboard
        } else {
            header("Location: user_dashboard.php");  // User Dashboard
        }
    } else {
        $error = "Invalid login credentials!";
    }
}
?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<?php if (isset($error)) echo "<p>$error</p>"; ?>
