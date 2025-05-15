<?php
session_start();

// Initialize products in session if not already set
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        ["T-Shirt", ["XS", "S", "M", "L", "XL"], ["Black", "White", "Gray"], "Uniqlo", 50, 10, "t-shirt.jpg"],
        ["Jeans", ["20", "22", "24", "26", "28", "30", "32", "34", "36", "38", "40", "42", "44", "45"], ["Blue", "Black", "Dark Blue"], "Levi's", 30, 25, "jeans.jpg"],
        ["Skirt", ["XS", "S", "M", "L", "XL"], ["Red", "Blue", "Pink"], "Zara", 0, 15, "skirt.jpg"],
        ["Crop Top", ["XS", "S", "M", "L"], ["White", "Pink", "Lavender"], "H&M", 8, 12, "crop top.jpg"],
        ["Trouser", ["20", "22", "24", "26", "28", "30", "32", "34", "36", "38", "40", "42", "44", "45"], ["Gray", "Beige", "Black"], "Gap", 35, 20, "trouser.jpg"],
        ["Jacket", ["S", "M", "L", "XL", "XXL"], ["Black", "Gray", "Navy"], "North Face", 5, 50, "jacket.jpg"],
        ["Blazer", ["XS", "S", "M", "L", "XL"], ["Navy", "Gray", "Black"], "Zalora", 25, 40, "blazer.jpg"],
        ["Shorts", ["20", "22", "24", "26", "28", "30", "32", "34", "36", "38", "40", "42", "44"], ["Khaki", "Olive", "Brown"], "Bench", 12, 18, "shorts.jpg"],
        ["Sweater", ["XS", "S", "M", "L", "XL"], ["Green", "Maroon", "Navy"], "Penshoppe", 9, 22, "sweater.jpg"],
        ["Hoodie", ["S", "M", "L", "XL", "XXL"], ["Black", "Red", "White"], "Adidas", 0, 35, "hoodie.jpg"]
    ];
}

$products = $_SESSION['products'];
$editIndex = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $sizes = explode(",", $_POST['sizes']);
        $colors = explode(",", $_POST['colors']);
        $brand = $_POST['brand'];
        $quantity = (int)$_POST['quantity'];
        $price = (float)$_POST['price'];
        $image = $_POST['image'];

        $products[] = [$name, $sizes, $colors, $brand, $quantity, $price, $image];
    }

    if (isset($_POST['edit_product'])) {
        $editIndex = $_POST['index'];
    }

    if (isset($_POST['save_edit'])) {
        $index = $_POST['index'];
        $name = $_POST['name'];
        $sizes = explode(",", $_POST['sizes']);
        $colors = explode(",", $_POST['colors']);
        $brand = $_POST['brand'];
        $quantity = (int)$_POST['quantity'];
        $price = (float)$_POST['price'];
        $image = $_POST['image'];

        $products[$index] = [$name, $sizes, $colors, $brand, $quantity, $price, $image];
    }

    if (isset($_POST['delete_product'])) {
        $index = $_POST['index'];
        unset($products[$index]);
        $products = array_values($products);
    }

    $_SESSION['products'] = $products;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory | StockHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            background-color: #f5f0ed;
        }

        .sidebar {
            width: 160px;
            background-color: #4E342E;
            color: #fff;
            height: 100vh;
            padding: 20px 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo {
            width: 100px;
            display: block;
            margin: 0 auto 30px auto;
        }

        .menu {
            list-style: none;
            padding: 0;
        }

        .menu li {
            margin: 25px 0;
            text-align: center;
        }

        .menu a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            display: block;
        }

        .logout {
            text-align: center;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-top: 1px solid #fff;
            margin-top: 30px;
            font-weight: bold;
        }

        .content {
            flex-grow: 1;
            padding: 20px 40px;
        }

        .topbar {
            background-color: #A1887F;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            border-radius: 10px;
        }

        .search-bar {
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #999;
            width: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #D7CCC8;
        }

        th {
            background-color: #6D4C41;
            color: #fff;
            padding: 12px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        .form-container {
            margin-top: 30px;
            background-color: #EFEBE9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .form-container input, .form-container select {
            padding: 8px;
            margin: 8px 0;
            width: 100%;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #6D4C41;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .form-container button:hover,
        .toggle-form-button:hover {
            background-color: #5D4037;
        }

        .toggle-form-button {
            background-color: #6D4C41;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
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
    <img src="logo.png" alt="Logo" class="logo">
    <ul class="menu">
        <li><a href="dashboard.php">🏠 Home</a></li>
        <li><a href="inventory.php">📦 Inventory</a></li>
        <li><a href="sales.php">📈 Sales</a></li>
        <li><a href="suppliers.php">🚚 Suppliers</a></li>
    </ul>
    <a href="logout.php" class="logout">🚪 Logout</a>
</div>

<div class="content">
    <div class="topbar">
        <h2>📦 Inventory</h2>
        <input type="text" class="search-bar" placeholder="Search Products...">
    </div>

    <table>
        <thead>
            <tr>
                <th>Image</th>
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
            <?php if ($editIndex !== null && $editIndex == $index): ?>
                <tr>
                    <form method="POST">
                        <td><input type="text" name="image" value="<?= htmlspecialchars($item[6]) ?>"></td>
                        <td><input type="text" name="name" value="<?= htmlspecialchars($item[0]) ?>"></td>
                        <td><input type="text" name="brand" value="<?= htmlspecialchars($item[3]) ?>"></td>
                        <td><input type="text" name="sizes" value="<?= htmlspecialchars(implode(",", $item[1])) ?>"></td>
                        <td><input type="text" name="colors" value="<?= htmlspecialchars(implode(",", $item[2])) ?>"></td>
                        <td><input type="number" name="quantity" value="<?= htmlspecialchars($item[4]) ?>"></td>
                        <td><input type="number" name="price" value="<?= htmlspecialchars($item[5]) ?>"></td>
                        <td>
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button type="submit" name="save_edit">💾 Save</button>
                        </td>
                    </form>
                </tr>
            <?php else: ?>
                <tr>
                    <td>
                        <?php
                            $imagePath = 'images/' . htmlspecialchars($item[6]);
                            if (file_exists($imagePath)) {
                                echo '<img src="' . $imagePath . '" class="product-img">';
                            } else {
                                echo '<span style="color:red;">Image not found</span>';
                            }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($item[0]) ?></td>
                    <td><?= htmlspecialchars($item[3]) ?></td>
                    <td><select><?php foreach ($item[1] as $size): ?><option><?= htmlspecialchars($size) ?></option><?php endforeach; ?></select></td>
                    <td><select><?php foreach ($item[2] as $color): ?><option><?= htmlspecialchars($color) ?></option><?php endforeach; ?></select></td>
                    <td><?= $item[4] ?></td>
                    <td>₱<?= number_format($item[5], 2) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button type="submit" name="edit_product">✏️ Edit</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button type="submit" name="delete_product" onclick="return confirm('Delete this product?')">🗑️ Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <button class="toggle-form-button" onclick="toggleForm()">➕ Add Product</button>

    <div class="form-container" id="addForm" style="display:none;">
        <form method="POST">
            <h3>Add New Product</h3>
            <input type="text" name="name" placeholder="Product Name" required><br>
            <input type="text" name="sizes" placeholder="Sizes (comma-separated)" required><br>
            <input type="text" name="colors" placeholder="Colors (comma-separated)" required><br>
            <input type="text" name="brand" placeholder="Brand" required><br>
            <input type="number" name="quantity" placeholder="Quantity" required><br>
            <input type="number" name="price" placeholder="Price" required><br>
            <input type="text" name="image" placeholder="Image filename (e.g. tshirt.jpg)" required><br>
            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>
</div>

</body>
</html>
