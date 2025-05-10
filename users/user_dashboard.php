// user_dashboard.php
<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome to your Dashboard, <?php echo htmlspecialchars($_SESSION["user"]); ?>!</h1>
    <p><a href="logout.php">Logout</a></p>

    <div class="product-list">
        <h2>Available Products</h2>
        <a href="product_detail.php?product=tshirt"><img src="images/tshirt.jpg" alt="T-Shirt" style="width: 100px;"></a>
        <a href="product_detail.php?product=jeans"><img src="images/jeans.jpg" alt="Jeans" style="width: 100px;"></a>
        <a href="product_detail.php?product=skirt"><img src="images/skirt.jpg" alt="Skirt" style="width: 100px;"></a>
        <!-- Add more products as needed -->
    </div>
</body>
</html>
