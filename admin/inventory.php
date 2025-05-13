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
        $products[] = [
            $_POST['name'],
            explode(",", $_POST['sizes']),
            explode(",", $_POST['colors']),
            $_POST['brand'],
            $_POST['quantity'],
            $_POST['price']
        ];
    }

    if (isset($_POST['edit_product'])) {
        $products[$_POST['index']] = [
            $_POST['name'],
            explode(",", $_POST['sizes']),
            explode(",", $_POST['colors']),
            $_POST['brand'],
            $_POST['quantity'],
            $_POST['price']
        ];
    }

    if (isset($_POST['delete_product'])) {
        unset($products[$_POST['index']]);
        $products = array_values($products);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StockHub Inventory Sidebar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .sidebar {
            position: fixed;
            right: -100%;
            top: 0;
            width: 70%;
            height: 100%;
            background-color: #f9f9f9;
            overflow-y: auto;
            transition: right 0.4s ease-in-out;
            padding: 20px;
            box-shadow: -2px 0 5px rgba(0,0,0,0.2);
            z-index: 999;
        }

        .sidebar.show {
            right: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        select, input {
            padding: 5px;
            margin-top: 5px;
        }

        .out-of-stock {
            color: red;
            font-weight: bold;
        }

        .form-container {
            margin: 20px 0;
        }

        .inventory-button {
            margin: 20px;
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .inventory-button:hover {
            background-color: #218838;
        }

        .close-button {
            float: right;
            background-color: red;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>


<button class="inventory-button" onclick="toggleSidebar()">Show Inventory</button>


<div id="inventorySidebar" class="sidebar">
    <button class="close-button" onclick="toggleSidebar()">X</button>
    <h2>Inventory Panel</h2>

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
                            <input type="text" name="name" value="<?= htmlspecialchars($item[0]) ?>" required>
                            <input type="text" name="sizes" value="<?= implode(",", $item[1]) ?>" required>
                            <input type="text" name="colors" value="<?= implode(",", $item[2]) ?>" required>
                            <input type="text" name="brand" value="<?= htmlspecialchars($item[3]) ?>" required>
                            <input type="number" name="quantity" value="<?= $item[4] ?>" required>
                            <input type="number" step="0.01" name="price" value="<?= $item[5] ?>" required>
                            <button type="submit" name="edit_product">Edit</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button type="submit" name="delete_product" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-container">
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

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('inventorySidebar');
        sidebar.classList.toggle('show');
    }
</script>

</body>
</html>
