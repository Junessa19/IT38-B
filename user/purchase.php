<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Purchase Page</h2>
<p>This is a placeholder for purchases.</p>
<a href="dashboard.php">Back to Dashboard</a>
