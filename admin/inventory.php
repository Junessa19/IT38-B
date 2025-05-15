<?php
session_start();

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
        $products[] = [
            $_POST['name'],
            explode(",", $_POST['sizes']),
            explode(",", $_POST['colors']),
            $_POST['brand'],
            (int)$_POST['quantity'],
            (float)$_POST['price'],
            $_POST['image']
        ];
    }

    if (isset($_POST['edit_product'])) {
        $editIndex = $_POST['index'];
    }

    if (isset($_POST['save_edit'])) {
        $products[$_POST['index']] = [
            $_POST['name'],
            explode(",", $_POST['sizes']),
            explode(",", $_POST['colors']),
            $_POST['brand'],
            (int)$_POST['quantity'],
            (float)$_POST['price'],
            $_POST['image']
        ];
    }

    if (isset($_POST['delete_product'])) {
        unset($products[$_POST['index']]);
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
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            background-color: #FBE9E7;
        }

        .sidebar {
            width: 180px;
            background-color: #5D4037;
            color: #fff;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo {
            width: 90px;
            display: block;
            margin: 0 auto 30px auto;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            margin: 15px 0;
            text-align: center;
        }

        .menu a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            font-size: 15px;
            padding: 8px;
            display: block;
            border-radius: 5px;
        }

        .menu a:hover {
            background-color: #6D4C41;
        }

        .logout {
            text-align: center;
            padding-top: 10px;
            border-top: 1px solid #fff;
            margin-top: 20px;
        }

        .logout a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .topbar {
            background-color: #D7CCC8;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 12px;
        }

        .search-bar {
            padding: 6px 10px;
            border-radius: 5px;
            border: 1px solid #aaa;
            width: 250px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #D7CCC8;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #A1887F;
            color: white;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        .form-container {
            background-color: #FFF3E0;
            padding: 20px;
            margin-top: 20px;
            border-radius: 12px;
        }

        .form-container input, .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .form-container button {
            background-color: #795548;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #6D4C41;
        }

        .toggle-form-button {
            background-color: #8D6E63;
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 6px;
            margin-top: 20px;
            cursor: pointer;
        }

        .toggle-form-button:hover {
            background-color: #6D4C41;
        }
    </style>
    <script>
        function toggleForm() {
            const form = document.getElementById("addForm");
            form.style.display = (form.style.display === "none") ? "block" : "none";
        }
    </script>
</head>
<body>

<div class="sidebar">
    <div>
        <img src="logo.png" alt="Logo" class="logo">
        <ul class="menu">
            <li><a href="dashboard.php">🏠 Home</a></li>
            <li><a href="inventory.php">📦 Inventory</a></li>
            <li><a href="sales.php">📈 Sales</a></li>
            <li><a href="suppliers.php">🚚 Suppliers</a></li>
        </ul>
    </div>
    <div class="logout">
        <a href="logout.php">🚪 Logout</a>
    </div>
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
                <th>Price</th>
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
                            echo file_exists($imagePath)
                                ? '<img src="' . $imagePath . '" class="product-img">'
                                : '<span style="color:red;">Image not found</span>';
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
                            <button type="submit" name="edit_product">✏️</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button type="submit" name="delete_product" onclick="return confirm('Delete this product?')">🗑️</button>
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
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="text" name="sizes" placeholder="Sizes (comma-separated)" required>
            <input type="text" name="colors" placeholder="Colors (comma-separated)" required>
            <input type="text" name="brand" placeholder="Brand" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <input type="number" name="price" placeholder="Price" required>
            <input type="text" name="image" placeholder="Image filename (e.g. tshirt.jpg)" required>
            <button type="submit" name="add_product">➕ Add Product</button>
        </form>
    </div>
</div>

</body>
</html>
