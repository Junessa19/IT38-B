<?php
session_start();

$products = [
    ["T-Shirt", ["XS", "S", "M", "L", "XL"], ["Black", "White", "Gray"], "Uniqlo", 50, 10],
    ["Jeans", ["20", "22", "24", "26", "28", "30", "32", "34", "36", "38", "40", "42", "44", "45"], ["Blue", "Black", "Dark Blue"], "Levi's", 30, 25],
    ["Skirt", ["XS", "S", "M", "L", "XL"], ["Red", "Blue", "Pink"], "Zara", 0, 15],
    ["Crop Top", ["XS", "S", "M", "L"], ["White", "Pink", "Lavender"], "H&M", 8, 12],
    ["Trouser", ["20", "22", "24", "26", "28", "30", "32", "34", "36", "38", "40", "42", "44", "45"], ["Gray", "Beige", "Black"], "Gap", 35, 20],
    ["Jacket", ["S", "M", "L", "XL", "XXL"], ["Black", "Gray", "Navy"], "North Face", 5, 50],
    ["Blazer", ["XS", "S", "M", "L", "XL"], ["Navy", "Gray", "Black"], "Zalora", 25, 40],
    ["Shorts", ["20", "22", "24", "26", "28", "30", "32", "34", "36", "38", "40", "42", "44"], ["Khaki", "Olive", "Brown"], "Bench", 12, 18],
    ["Sweater", ["XS", "S", "M", "L", "XL"], ["Green", "Maroon", "Navy"], "Penshoppe", 9, 22],
    ["Hoodie", ["S", "M", "L", "XL", "XXL"], ["Black", "Red", "White"], "Adidas", 0, 35],
    ["Leggings", ["XS", "S", "M", "L", "XL"], ["Black", "Purple", "Gray"], "Nike", 15, 30],
    ["Blouse", ["XS", "S", "M", "L"], ["Peach", "Cream", "White"], "Forever 21", 18, 28],
    ["Polo Shirt", ["S", "M", "L", "XL"], ["White", "Blue", "Green"], "Lacoste", 22, 32],
    ["Tank Top", ["XS", "S", "M", "L"], ["Yellow", "White", "Coral"], "H&M", 11, 14],
    ["Cardigan", ["S", "M", "L", "XL"], ["Beige", "Gray", "Brown"], "Zara", 6, 24],
    ["Denim Jacket", ["M", "L", "XL", "XXL"], ["Denim", "Black", "Light Blue"], "Levi's", 13, 48],
    ["Tracksuit", ["S", "M", "L", "XL"], ["Gray", "Navy", "Black"], "Adidas", 20, 55],
    ["Overalls", ["XS", "S", "M", "L", "XL"], ["Blue", "Dark Blue", "Denim"], "Gap", 4, 42],
    ["Raincoat", ["XS", "S", "M", "L", "XL"], ["Yellow", "Transparent", "Gray"], "Uniqlo", 2, 36],
    ["Kimono", ["One Size"], ["Pink", "Floral", "White"], "Japan Style", 7, 38],
    ["New Product", ["XS", "S", "M", "L", "XL"], ["Color1", "Color2", "Color3"], "Brand Name", 10, 20]
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
            margin-top: 20px;
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

        .form-container {
            display: none;
            margin-top: 20px;
            text-align: center;
        }

        .form-container form {
            display: inline-block;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .form-container input {
            margin: 5px 0;
            padding: 8px;
            width: 250px;
        }

        .inventory-section {
            padding: 20px;
        }

        .toggle-form-button {
            display: block;
            margin: 30px auto 20px auto;
            padding: 14px 40px;
            width: 250px;
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .toggle-form-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function toggleForm() {
            const form = document.getElementById("addForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
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

        <div class="inventory-section">

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

            <button class="toggle-form-button" onclick="toggleForm()">➕ Add Product</button>

            <div class="form-container" id="addForm">
                <form method="POST">
                    <h3>Add New Product</h3>
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
