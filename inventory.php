<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "your_database_name"); // Update DB name
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect filter values
$size = $_GET['size'] ?? '';
$color = $_GET['color'] ?? '';
$brand = $_GET['brand'] ?? '';
$stock = $_GET['stock_status'] ?? '';

// Prepare SQL with dynamic conditions
$params = [];
$types = '';
$conditions = [];

if ($size !== '') {
    $conditions[] = "size = ?";
    $params[] = $size;
    $types .= 's';
}
if ($color !== '') {
    $conditions[] = "color = ?";
    $params[] = $color;
    $types .= 's';
}
if ($brand !== '') {
    $conditions[] = "brand = ?";
    $params[] = $brand;
    $types .= 's';
}
if ($stock !== '') {
    $conditions[] = "stock_status = ?";
    $params[] = $stock;
    $types .= 's';
}

$sql = "SELECT * FROM inventory";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <style>
        body { font-family: Arial; background: #f7f4ed; padding: 20px; }
        select, input[type="submit"] {
            padding: 8px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #999;
            text-align: center;
        }
        th { background: #8B6F3F; color: white; }
    </style>
</head>
<body>

<h2>📦 Inventory</h2>

<form method="GET">
    <label>Size:
        <select name="size">
            <option value="">All</option>
            <option value="S" <?= $size == 'S' ? 'selected' : '' ?>>Small</option>
            <option value="M" <?= $size == 'M' ? 'selected' : '' ?>>Medium</option>
            <option value="L" <?= $size == 'L' ? 'selected' : '' ?>>Large</option>
        </select>
    </label>

    <label>Color:
        <select name="color">
            <option value="">All</option>
            <option value="Brown" <?= $color == 'Brown' ? 'selected' : '' ?>>Brown</option>
            <option value="Black" <?= $color == 'Black' ? 'selected' : '' ?>>Black</option>
            <option value="White" <?= $color == 'White' ? 'selected' : '' ?>>White</option>
        </select>
    </label>

    <label>Brand:
        <select name="brand">
            <option value="">All</option>
            <option value="Brand A" <?= $brand == 'Brand A' ? 'selected' : '' ?>>Brand A</option>
            <option value="Brand B" <?= $brand == 'Brand B' ? 'selected' : '' ?>>Brand B</option>
        </select>
    </label>

    <label>Stock Status:
        <select name="stock_status">
            <option value="">All</option>
            <option value="In Stock" <?= $stock == 'In Stock' ? 'selected' : '' ?>>In Stock</option>
            <option value="Low Stock" <?= $stock == 'Low Stock' ? 'selected' : '' ?>>Low Stock</option>
            <option value="Out of Stock" <?= $stock == 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
        </select>
    </label>

    <input type="submit" value="Filter">
</form>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Size</th>
            <th>Color</th>
            <th>Brand</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total Value</th>
            <th>Stock Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= htmlspecialchars($row['size']) ?></td>
                    <td><?= htmlspecialchars($row['color']) ?></td>
                    <td><?= htmlspecialchars($row['brand']) ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td>₱<?= number_format($row['unit_price'], 2) ?></td>
                    <td>₱<?= number_format($row['total_value'], 2) ?></td>
                    <td><?= htmlspecialchars($row['stock_status']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">No items found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
