<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>

<style>
    /* Insert your full CSS here from the dashboard */
</style>

<div class="sidebar">
    <div class="logo-container">
        <img src="logo.png" alt="Logo" class="logo">
    </div>
    <ul class="menu">
        <li><a href="dashboard.php">🏠 Home</a></li>
        <li><a href="inventory.php">📦 Inventory</a></li>
        <li><a href="sales.php">📈 Sales</a></li>
        <li><a href="suppliers.php">🚚 Suppliers</a></li>
        <li><a href="reports.php">📊 Reports</a></li>
    </ul>
    <a href="logout.php" class="logout">🚪 Logout</a>
</div>
