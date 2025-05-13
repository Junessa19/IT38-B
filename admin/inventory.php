<?php
session_start();



$products = [
    ["T-Shirt", ["S", "M", "L"], ["Black", "White"], "Uniqlo", 50, 10],
    ["Jeans", ["28", "30", "32"], ["Blue", "Black"], "Levi's", 30, 25],
    ["Skirt", ["S", "M", "L"], ["Red", "Blue"], "Zara", 0, 15],
    ["Crop Top", ["XS", "S", "M"], ["White", "Pink"], "H&M", 8, 12],
    ["Trouser", ["30", "32", "34"], ["Gray", "Beige"], "Gap", 35, 20],
    ["Jacket", ["M", "L", "XL"], ["Black", "Gray"], "North Face", 5, 50],
    ["Blazer", ["S", "M", "L"], ["Navy", "Gray"], "Zalora", 25, 40],
    ["Shorts", ["28", "30", "32"], ["Khaki", "Olive"], "Bench", 12, 18],
    ["Sweater", ["S", "M", "L"], ["Green", "Maroon"], "Penshoppe", 9, 22],
    ["Hoodie", ["M", "L", "XL"], ["Black", "Red"], "Adidas", 0, 35],
    ["Leggings", ["S", "M", "L"], ["Black", "Purple"], "Nike", 15, 30],
    ["Blouse", ["XS", "S", "M"], ["Peach", "Cream"], "Forever 21", 18, 28],
    ["Polo Shirt", ["S", "M", "L"], ["White", "Blue"], "Lacoste", 22, 32],
    ["Tank Top", ["XS", "S", "M"], ["Yellow", "White"], "H&M", 11, 14],
    ["Cardigan", ["S", "M", "L"], ["Beige", "Gray"], "Zara", 6, 24],
    ["Denim Jacket", ["M", "L", "XL"], ["Denim", "Black"], "Levi's", 13, 48],
    ["Tracksuit", ["M", "L", "XL"], ["Gray", "Navy"], "Adidas", 20, 55],
    ["Overalls", ["S", "M", "L"], ["Blue", "Dark Blue"], "Gap", 4, 42],
    ["Raincoat", ["S", "M", "L"], ["Yellow", "Transparent"], "Uniqlo", 2, 36],
    ["Kimono", ["One Size"], ["Pink", "Floral"], "Japan Style", 7, 38],
    ["New Product", ["S", "M", "L"], ["Color1", "Color2"], "Brand Name", 10, 20]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $sizes = explode(",", $_POST['sizes']);
        $colors = explode(",", $_POST['colors']);
        $brand = $_POST['brand'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $products[] = [$name, $sizes, $colors, $brand, $quantity, $price];
    }

    if (isset($_POST['edit_product'])) {
        $index = $_POST['index'];
        $name = $_POST['name'];
        $sizes = explode(",", $_POST['sizes']);
        $colors = explode(",", $_POST['colors']);
        $brand = $_POST['brand'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $products[$index] = [$name, $sizes, $colors, $brand, $quantity, $price];
    }

    if (isset($_POST['delete_product'])) {
        $index = $_POST['index'];
        unset($products[$index]);
        $products = array_values($products);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory | StockHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; display: flex; height: 100vh; }

        .sidebar {
            width: 250px;
            background: #8B6F3F;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .logo-container { display: flex; align-items: center; gap: 10px; }
        .logo { width: 70px; height: 70px; border-radius: 50%; background: white; object-fit: cover; }
        .menu { list-style: none; padding: 20px 0; }
        .menu li { margin: 15px 0; }
        .menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 16px;
            padding: 8px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .menu a:hover { background: rgba(255, 255, 255, 0.2); }
        .logout { margin-top: 30px; font-weight: bold; }

        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            background: #C7A061;
            min-height: 220vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #8B6F3F;
            padding: 15px;
            color: white;
        }

        .search-bar {
            padding: 8px;
            border-radius: 5px;
            border: none;
            width: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        select, input {
            padding: 5px;
        }

        .out-of-stock {
            color: red;
            font-weight: bold;
        }

        .back-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .form-container {
            margin: 20px 0;
        }

        .inventory-section {
            padding: 20px;
        }
    </style>
</head>
<body>

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

    <div class="content">
        <div class="topbar">
            <h2>📦 Inventory</h2>
            <input type="text" class="search-bar" placeholder="Search Products...">
        </div>

        <button class="toggle-form-button" onclick="toggleForm()">➕ Add Product</button>

        <div class="inventory-section">
            <button class="back-button" onclick="window.history.back()">Go Back</button>

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Sizes</th>
                        <th>Colors</th>
                        <th>Quantity</th>
                        <th>Price (₱)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item[0]) ?></td>
                        <td><?= htmlspecialchars($item[3]) ?></td>
                        <td>
                            <select>
                                <?php foreach ($item[1] as $size): ?>
                                    <option><?= htmlspecialchars($size) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select>
                                <?php foreach ($item[2] as $color): ?>
                                    <option><?= htmlspecialchars($color) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="<?= $item[4] <= 0 ? 'out-of-stock' : '' ?>">
                            <?= $item[4] <= 0 ? 'Out of Stock' : $item[4] ?>
                        </td>
                        <td>₱<?= number_format($item[5], 2) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button type="submit" name="edit_product">Edit</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button type="submit" name="delete_product" onclick="return confirm('Delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

           <div class="form-container" id="productForm" style="display: none;">
    <h3>Add New Product</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required><br>
        <input type="text" name="sizes" placeholder="Sizes (comma-separated)" required><br>
        <input type="text" name="colors" placeholder="Colors (comma-separated)" required><br>
        <input type="text" name="brand" placeholder="Brand" required><br>
        <input type="number" name="quantity" placeholder="Quantity" required><br>
        <input type="number" step="0.01" name="price" placeholder="Price" required><br>
        <button type="submit" name="add_product">Add Product</button>
            </form>
        </div>
        </div>
    </div>

</body>
</html>
