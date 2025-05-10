<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Shop</title>
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
            justify-content: space-between;
        }
        .logo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            object-fit: cover;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            align-self: center;
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

        .search-bar {
            padding: 8px;
            border-radius: 5px;
            border: none;
            width: 200px;
        }

        .logout-btn {
            background: #6b5430;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #5a3e1b;
        }

        .profile-section {
            position: fixed;
            top: 15px;
            right: 15px;
            background: #8B6F3F;
            color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
        }

        .profile-section h3 {
            margin-bottom: 10px;
        }

        .profile-section button {
            width: 100%;
            background: #6b5430;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-section button:hover {
            background: #5a3e1b;
        }

        .product-section {
            padding: 20px;
        }

        h2 {
            color: #5a3e1b;
            margin-bottom: 20px;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .product-card {
            background: white;
            padding: 15px;
            width: 220px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-card h3 {
            color: #5a3e1b;
            margin: 10px 0 5px;
        }

        .product-card p {
            margin: 5px 0;
        }

        .product-card select,
        .product-card input[type="number"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        .product-card button {
            width: 100%;
            background: #8B6F3F;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
        }

        .product-card button:hover {
            background: #6b5430;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="logo.png" alt="Logo" class="logo">
        <a href="?logout=true"><button class="logout-btn">Logout</button></a>
    </div>

    <div class="content">
        <div class="topbar">
            <div class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION["user"]); ?>! 🛍️</div>
            <input type="text" class="search-bar" placeholder="Search products...">
        </div>

        <div class="profile-section">
            <h3><?php echo htmlspecialchars($_SESSION["user"]); ?>'s Profile</h3>
            <a href="orders.php"><button>My Orders</button></a>
        </div>

        <div class="product-section">
            <h2>Available Products</h2>
            <div class="product-grid">
                <?php
                $products = [
                    ["T-Shirt", ["S", "M", "L"], ["Black", "White"], "Uniqlo", 50, 10],
                    ["Jeans", ["28", "30", "32"], ["Blue", "Black"], "Levi's", 30, 25],
                    ["Skirt", ["S", "M", "L"], ["Red", "Blue"], "Zara", 20, 15],
                    ["Crop Top", ["XS", "S", "M", "XL", "XXL"], ["White", "Pink"], "H&M", 40, 12],
                    ["Trouser", ["20", "30", "32", "34"], ["Gray", "Beige"], "Gap", 35, 20]
                ];

                foreach ($products as $item) {
                    $productName = $item[0];
                    $sizes = $item[1];
                    $colors = $item[2];
                    $brand = $item[3];
                    $available = $item[4];
                    $price = $item[5];

                    $imageFile = strtolower(str_replace(' ', '-', $productName)) . ".jpg";

                    echo "<div class='product-card'>";
                    echo "<img src='images/$imageFile' alt='$productName'>";
                    echo "<h3>$productName</h3>";
                    echo "<p>Brand: $brand</p>";
                    echo "<p>Available: $available</p>";
                    echo "<p>Price: ₱" . number_format($price, 2) . "</p>";
                    echo "<form method='POST' action='purchase.php'>";
                    echo "<input type='hidden' name='product' value='$productName'>";
                    echo "<input type='hidden' name='price' value='$price'>";
                    echo "<label>Size:</label>";
                    echo "<select name='size' required><option value=''>Select</option>";
                    foreach ($sizes as $s) echo "<option value='$s'>$s</option>";
                    echo "</select>";
                    echo "<label>Color:</label>";
                    echo "<select name='color' required><option value=''>Select</option>";
                    foreach ($colors as $c) echo "<option value='$c'>$c</option>";
                    echo "</select>";
                    echo "<label>Quantity:</label>";
                    echo "<input type='number' name='quantity' min='1' max='$available' required>";
                    echo "<button type='submit'>Purchase</button>";
                    echo "</form>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
