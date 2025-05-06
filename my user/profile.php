<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

include('db.php');

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Update user profile in database
    $update_sql = "UPDATE users SET email = ?, password = ? WHERE id = ?";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute([$email, $password, $_SESSION['user_id']]);

    echo "Profile updated successfully!";
}
?>

<form method="POST" action="">
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <input type="password" name="password" placeholder="New Password" required>
    <button type="submit">Update Profile</button>
</form>
