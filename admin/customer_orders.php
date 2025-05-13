<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Database credentials
$servername = "localhost";
$dbUsername = "root";          // XAMPP default
$dbPassword = "";              // XAMPP default (blank)
$dbName     = "clothing_store"; // ← your actual DB name

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders (without status)
$sql = "SELECT user_id, product_name, size, color, quantity, total_price, order_date
        FROM orders
        ORDER BY order_date DESC";
$result = $conn->query($sql);
if (!$result) {
    die("Error retrieving orders: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Orders</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        h2 { margin-bottom: 20px; color: #5a3e1b; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background: #8B6F3F; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>
    <h2>📋 All Customer Orders</h2>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Product</th>
                <th>Size</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["user_id"]) ?></td>
                    <td><?= htmlspecialchars($row["product_name"]) ?></td>
                    <td><?= htmlspecialchars($row["size"]) ?></td>
                    <td><?= htmlspecialchars($row["color"]) ?></td>
                    <td><?= (int)$row["quantity"] ?></td>
                    <td>₱<?= number_format($row["total_price"], 2) ?></td>
                    <td><?= htmlspecialchars($row["order_date"]) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$result->free();
$conn->close();
?>
