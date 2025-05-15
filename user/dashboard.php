<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$host = 'localhost';
$db   = 'clothing_store';
$user = 'root';
$pass = '';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $stmt = $pdo->query("SELECT * FROM products WHERE quantity > 0");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            flex-direction: column;
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
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            margin-bottom: 15px;
        }

        .orders-button {
            background: white;
            color: #8B6F3F;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
        }

        .orders-button:hover {
            background: #f0e0c0;
        }

        .logout-link {
            margin-top: auto;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            background: #C7A061;
            min-height: 280vh;
            padding-top: 80px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .product-section { padding: 20px; }
        h2 { color: #5a3e1b; margin-bottom: 20px; }

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

        .product-card p { margin: 5px 0; }

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

        .product-card button:hover { background: #6b5430; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="welcome">
            Welcome, <?= htmlspecialchars($_SESSION['user']) ?>! 🛍️
        </div>
    </div>

    <div class="sidebar">
        <img src="logo.png" alt="Logo" class="logo" />
        <a href="orders.php" class="orders-button">My Orders</a>
        <a href="logout.php" class="logout-link">🚪 Logout</a>
    </div>

    <div class="content">
        <div class="product-section">
            <h2>Available Products</h2>
            <div class="product-grid">
                <?php foreach ($products as $product): 
                    $sizes = explode(',', $product['sizes']);
                    $colors = explode(',', $product['colors']);
                ?>
                    <div class="product-card">
                        <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" />
                        <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                        <p>Brand: <?= htmlspecialchars($product['brand']) ?></p>
                        <p>Available: <?= $product['quantity'] ?></p>
                        <p>Price: ₱<?= number_format($product['price'], 2) ?></p>

                        <form method="POST" action="purchase.php">
                            <input type="hidden" name="product" value="<?= htmlspecialchars($product['product_name']) ?>" />
                            <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']) ?>" />
                            
                            <label>Size:</label>
                            <select name="size" required>
                                <option value="">Select</option>
                                <?php foreach ($sizes as $size): ?>
                                    <option value="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label>Color:</label>
                            <select name="color" required>
                                <option value="">Select</option>
                                <?php foreach ($colors as $color): ?>
                                    <option value="<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($color) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label>Quantity:</label>
                            <input type="number" name="quantity" min="1" max="<?= $product['quantity'] ?>" required />
                            <button type="submit">Purchase</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
