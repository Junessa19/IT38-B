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
?>

<h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
<p>Account Created On: <?php echo htmlspecialchars($user['created_at']); ?></p>

<h2>Your Dashboard</h2>
<nav>
    <ul>
        <li><a href="profile.php">Edit Profile</a></li>
        <li><a href="order_history.php">Order History</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
