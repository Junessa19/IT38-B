<?php
session_start();


if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}


$user_id = (int) $_SESSION['user'];


$host     = 'localhost';
$dbName   = 'clothing_store';  
$dbUser   = 'root';            
$dbPass   = '';                


$conn = new mysqli($host, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare(
    "SELECT product_name, size, color, quantity, total_price, order_date
     FROM orders
     WHERE user_id = ?
     ORDER BY order_date DESC"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; padding: 20px; }
        h2 { margin-bottom: 20px; color: #8B6F3F; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background: #8B6F3F; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>
    <h2>🛒 My Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($orders->num_rows > 0): ?>
                <?php while ($row = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= htmlspecialchars($row['size']) ?></td>
                    <td><?= htmlspecialchars($row['color']) ?></td>
                    <td><?= (int)$row['quantity'] ?></td>
                    <td>₱<?= number_format($row['total_price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">You have no orders yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
