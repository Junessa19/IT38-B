<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product  = trim($_POST['product']);
    $size     = trim($_POST['size']);
    $color    = trim($_POST['color']);
    $quantity = (int) $_POST['quantity'];
    $price    = (float) $_POST['price'];  // You can keep price for total calculation only
    $total    = $quantity * $price;

    // Database connection info
    $host = 'localhost';
    $db   = 'clothing_store';
    $user = 'root';
    $pass = '';
    $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Step 1: Find the product id and check stock with size and color (LIKE for CSV matching)
        $check_sql = "SELECT id, quantity FROM products
                      WHERE product_name = :product_name
                      AND CONCAT(',', sizes, ',') LIKE CONCAT('%,', :size, ',%')
                      AND CONCAT(',', colors, ',') LIKE CONCAT('%,', :color, ',%')
                      LIMIT 1";

        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([
            ':product_name' => $product,
            ':size'         => $size,
            ':color'        => $color
        ]);

        $productData = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$productData) {
            die("❌ Product not found.");
        }

        if ($productData['quantity'] < $quantity) {
            die("❌ Not enough stock available.");
        }

        // Step 2: Insert the order with product_id, user_id, quantity, order_date
        $order_sql = "INSERT INTO orders (user_id, product_id, quantity, order_date)
                      VALUES (:user_id, :product_id, :quantity, NOW())";

        $order_stmt = $pdo->prepare($order_sql);
        $order_stmt->execute([
            ':user_id'    => $_SESSION['user'],  // Make sure $_SESSION['user'] contains user ID
            ':product_id' => $productData['id'],
            ':quantity'   => $quantity,
        ]);

        // Step 3: Update product stock quantity
        $update_sql = "UPDATE products
                       SET quantity = quantity - :quantity
                       WHERE id = :product_id";

        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([
            ':quantity'   => $quantity,
            ':product_id' => $productData['id'],
        ]);

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }

    // Show confirmation page
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8" />
        <title>Purchase Confirmation</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #C7A061;
                padding: 40px;
            }
            .container {
                max-width: 600px;
                margin: auto;
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                color: #333;
                text-align: center;
            }
            h2 {
                color: #5a3e1b;
                margin-bottom: 20px;
            }
            .highlight {
                font-weight: bold;
            }
            a.back {
                display: inline-block;
                margin-top: 20px;
                text-decoration: none;
                background: #8B6F3F;
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
            }
            a.back:hover {
                background: #6b5430;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>✅ Purchase Confirmed!</h2>
            <p>
                Product: <span class="highlight"><?= htmlspecialchars($product) ?></span><br />
                Size: <span class="highlight"><?= htmlspecialchars($size) ?></span><br />
                Color: <span class="highlight"><?= htmlspecialchars($color) ?></span><br />
                Quantity: <span class="highlight"><?= $quantity ?></span><br />
                Total: <span class="highlight">₱<?= number_format($total, 2) ?></span>
            </p>
            <a class="back" href="dashboard.php">⬅ Back to Dashboard</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

header('Location: dashboard.php');
exit();
?>
