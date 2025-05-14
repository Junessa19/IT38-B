<?php
include __DIR__ . '/../db_connection.php';

$supplier_id = 1; // Replace this with session logic when available

// Optional: Insert sample 50 products if needed (only once)
$check = mysqli_query($conn, "SELECT COUNT(*) as total FROM supplier_products WHERE supplier_id = $supplier_id");
$row = mysqli_fetch_assoc($check);
if ($row['total'] == 0) {
    $sample_products = [
        ["T-Shirt", ["XS", "S", "M", "L", "XL"], ["Black", "White", "Gray"], "Uniqlo", 50, 10, "tshirt.jpg"],
        ["Jeans", ["20", "22", "24", "26", "28", "30"], ["Blue", "Black"], "Levi's", 30, 25, "jeans.jpg"],
        ["Skirt", ["XS", "S", "M"], ["Red", "Blue"], "Zara", 0, 15, "skirt.jpg"],
        ["Crop Top", ["XS", "S", "M"], ["Pink", "Lavender"], "H&M", 8, 12, "crop_top.jpg"],
        ["Trouser", ["26", "28", "30"], ["Gray", "Beige"], "Gap", 35, 20, "trouser.jpg"],
        ["Jacket", ["M", "L", "XL"], ["Black", "Navy"], "North Face", 5, 50, "jacket.jpg"],
        ["Blazer", ["S", "M", "L"], ["Gray", "Black"], "Zalora", 25, 40, "blazer.jpg"],
        ["Shorts", ["26", "28", "30"], ["Khaki", "Olive"], "Bench", 12, 18, "shorts.jpg"],
        ["Sweater", ["S", "M", "L"], ["Green", "Navy"], "Penshoppe", 9, 22, "sweater.jpg"],
        ["Hoodie", ["M", "L", "XL"], ["Black", "Red"], "Adidas", 0, 35, "hoodie.jpg"]
    ];

    for ($i = 1; $i <= 5; $i++) {
        foreach ($sample_products as $product) {
            $name = $product[0] . " $i";
            $size = $product[1][array_rand($product[1])];
            $color = $product[2][array_rand($product[2])];
            $brand = $product[3];
            $price = $product[4];
            $quantity = $product[5];
            $image = $product[6];

            $stmt = $conn->prepare("INSERT INTO supplier_products (supplier_id, product_name, size, color, brand, price, available_quantity, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssdis", $supplier_id, $name, $size, $color, $brand, $price, $quantity, $image);
            $stmt->execute();
        }
    }
}

// Fetch products
$sql = "SELECT * FROM supplier_products WHERE supplier_id = $supplier_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #8B6F3F;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: white;
            object-fit: cover;
        }
        .menu {
            list-style: none;
            padding: 20px 0;
        }
        .menu li {
            margin: 15px 0;
        }
        .menu a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            padding: 8px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .logout {
            margin-top: 30px;
            font-weight: bold;
            color: white;
            display: inline-block;
            text-decoration: none;
        }
        .main {
            margin-left: 250px;
            width: calc(100% - 250px);
            background: #C7A061;
            min-height: 100vh;
            padding: 20px;
        }
        h1, h2 {
            color: #fff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #8B6F3F;
            color: white;
        }
        table tr:hover {
            background-color: #f5f5f5;
        }
        a.action-link {
            color: #8B6F3F;
            font-weight: bold;
            text-decoration: none;
        }
        a.action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-container">
            <img src="logo.png" alt="Logo" class="logo">
        </div>
        <ul class="menu">
            <li><a href="supplier_dashboard.php">📋 Dashboard</a></li>
            <li><a href="add_product.php">➕ Add Product</a></li>
            <li><a href="handle_requests.php">📥 Handle Requests</a></li>
        </ul>
        <a href="../logout.php" class="logout">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h1>Supplier Dashboard</h1>

        <div id="Products">
            <h2>📦 Your Products</h2>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Available Qty</th>
                    <th>Actions</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['product_name']}</td>
                            <td>{$row['size']}</td>
                            <td>{$row['color']}</td>
                            <td>₱{$row['price']}</td>
                            <td>{$row['available_quantity']}</td>
                            <td>
                                <a class='action-link' href='edit_product.php?id={$row['id']}'>Edit</a> |
                                <a class='action-link' href='handle_requests.php?action=delete_product&id={$row['id']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>
</html>

<?php mysqli_close($conn); ?>
