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
            height: 100vh;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .logo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            object-fit: cover;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            background: #C7A061;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #8B6F3F;
            padding: 15px;
            color: white;
        }

        .welcome {
            font-size: 20px;
            font-weight: bold;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-bar {
            padding: 8px;
            border-radius: 5px;
            border: none;
            width: 200px;
        }

        .logout-button {
            padding: 8px 12px;
            background: #C1440E;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #a6360c;
        }

        .product-section {
            padding: 20px;
        }

        h2 {
            color: #5a3e1b;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        button {
            background: #8B6F3F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #6b5430;
        }

        .product-gallery {
    padding: 20px;
}
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
}
.card {
    background: white;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
}
.card h3 {
    margin: 10px 0;
    color: #5a3e1b;
}
.card a {
    display: inline-block;
    background: #8B6F3F;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    text-decoration: none;
}
.card a:hover {
    background: #6b5430;
}

    </style>
</head>
<body>
    <div class="sidebar">
        <img src="logo.png" alt="Logo" class="logo">
    </div>

    <div class="product-gallery">
    <h2>Shop Items</h2>
    <div class="cards">
        <?php
        $items = [
            ["T-Shirt", "tshirt.jpg"],
            ["Jeans", "jeans.jpg"],
            ["Skirt", "skirt.jpg"],
            ["Crop Top", "croptop.jpg"],
            ["Trouser", "trouser.jpg"],
            ["Short", "short.jpg"]
        ];

        foreach ($items as $item) {
            $name = $item[0];
            $img = $item[1];
            echo "
            <div class='card'>
                <img src='images/$img' alt='$name'>
                <h3>$name</h3>
                <a href='product_detail.php?product=" . urlencode($name) . "'>View Details</a>
            </div>";
        }
        ?>
    </div>
</div>

            </div>
        </div>

        <div class="product-section">
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
                    ["Crop Top", ["XS", "S", "M", "XL", "XXL"], ["White", "Pink"], "H&M", 40, 12],
                    ["Trouser", ["20", "30", "32", "34"], ["Gray", "Beige"], "Gap", 35, 20]
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
        </div>
    </div>
</body>
</html>
