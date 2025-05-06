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
    <title>User Dashboard - Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6e9d7;
            padding: 20px;
        }
        h1 {
            color: #5a3e1b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #8B6F3F;
            color: white;
        }
        select, input[type="number"], button {
            padding: 5px;
            margin: 5px 0;
        }
        .logout {
            float: right;
            text-decoration: none;
            background: #8B6F3F;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<a class="logout" href="logout.php">Logout</a>
<h1>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>! 🛍️</h1>
<h2>Available Products</h2>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Size</th>
            <th>Color</th>
            <th>Brand</th>
            <th>Available</th>
            <th>Price</th>
            <th>Quantity to Buy</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
<?php
$products = [
    ["T-Shirt", ["S", "M", "L"], ["Black", "White"], "Uniqlo", 50, 10],
    ["Jeans", ["28", "30", "32"], ["Blue", "Black"], "Levi's", 30, 25],
    ["Skirt", ["S", "M", "L"], ["Red", "Blue"], "Zara", 20, 15],
    ["Crop Top", ["XS", "S", "M"], ["White", "Pink"], "H&M", 40, 12],
    ["Trouser", ["30", "32", "34"], ["Gray", "Beige"], "Gap", 35, 20]
];

foreach ($products as $index => $item) {
    $productName = $item[0];
    $sizes = $item[1];
    $colors = $item[2];
    $brand = $item[3];
    $available = $item[4];
    $price = $item[5];

    echo "<tr>";
    echo "<form method='POST' action='purchase.php'>";
    echo "<td>$productName<input type='hidden' name='product' value='$productName'></td>";

    echo "<td><select name='size' required><option value=''>Select</option>";
    foreach ($sizes as $s) echo "<option value='$s'>$s</option>";
    echo "</select></td>";

    echo "<td><select name='color' required><option value=''>Select</option>";
    foreach ($colors as $c) echo "<option value='$c'>$c</option>";
    echo "</select></td>";

    echo "<td>$brand</td>";
    echo "<td>$available</td>";
    echo "<td>₱" . number_format($price, 2) . "<input type='hidden' name='price' value='$price'></td>";
    echo "<td><input type='number' name='quantity' min='1' max='$available' required></td>";
    echo "<td><button type='submit'>Purchase</button></td>";
    echo "</form>";
    echo "</tr>";
}
?>
    </tbody>
</table>

</body>
</html>
    