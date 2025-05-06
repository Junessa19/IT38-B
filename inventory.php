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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #8B6F3F;
            color: white;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            position: fixed;
            left: 0;
            top: 0;
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
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
            display: flex;
            align-items: center;
            font-size: 16px;
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
        }
        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            background: #C7A061;
            min-height: 200vh;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #876F3A;
            padding: 15px;
            color: white;
            width: 100%;
        }
        .search-bar {
            padding: 8px;
            border-radius: 5px;
            border: none;
            width: 200px;
        }
        .dashboard-content {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            min-height: 150px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: center;
        }
        th {
            background-color: #eee;
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
            <input type="text" class="search-bar" placeholder="Search...">
        </div>
        <div class="dashboard-content">
            <!-- Product List Card -->
            <div class="card" onclick="toggleProductList()">
                👕 Product List
                <div id="productTable" style="display: none; margin-top: 15px;">
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
                            <?php
                            $products = [
                                ["T-Shirt", "S/M/L", "Black/White", "Uniqlo", 50, 10],
                                ["Jeans", "28/30/32", "Blue/Black", "Levi's", 30, 25],
                                ["Skirt", "S/M/L", "Red/Blue", "Zara", 20, 15],
                                ["Crop Top", "XS/S/M", "White/Pink", "H&M", 40, 12],
                                ["Trouser", "30/32/34", "Gray/Beige", "Gap", 35, 20],
                                ["Short", "S/M/L", "Denim/Black", "Forever21", 25, 14],
                                ["Polo Shirt", "M/L/XL", "Navy/White", "Lacoste", 45, 18],
                                ["Midi Dress", "S/M", "Floral/Red", "Mango", 15, 28],
                                ["Sports Leggings", "S/M/L", "Black/Grey", "Nike", 20, 22],
                                ["Wool Sweater", "M/L", "Cream/Brown", "Uniqlo", 10, 30],
                                ["Chino Pants", "30/32", "Khaki/Navy", "Dockers", 18, 27],
                                ["Maki Skirt", "One Size", "Multicolor", "Local", 12, 16]
                            ];

                            foreach ($products as $item) {
                                $total = $item[4] * $item[5];
                                $status = $item[4] <= 10 ? "Low Stock" : "In Stock";
                                echo "<tr>";
                                echo "<td>{$item[0]}</td>";
                                echo "<td>{$item[1]}</td>";
                                echo "<td>{$item[2]}</td>";
                                echo "<td>{$item[3]}</td>";
                                echo "<td>{$item[4]}</td>";
                                echo "<td>₱" . number_format($item[5], 2) . "</td>";
                                echo "<td>₱" . number_format($total, 2) . "</td>";
                                echo "<td>$status</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleProductList() {
            const productTable = document.getElementById("productTable");
            productTable.style.display = (productTable.style.display === "none") ? "block" : "none";
        }
    </script>
</body>
</html>
