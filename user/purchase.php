<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product  = $_POST['product'];
    $size     = $_POST['size'];
    $color    = $_POST['color'];
    $quantity = (int) $_POST['quantity'];
    $price    = (float) $_POST['price'];
    $total    = $quantity * $price;

    $host = 'localhost';
    $db   = 'clothing_store';
    $user = 'root';
    $pass = '';
    $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $check_sql = "SELECT quantity FROM products
                      WHERE name = :product_name
                      AND FIND_IN_SET(:size, sizes) > 0
                      AND FIND_IN_SET(:color, colors) > 0
                      LIMIT 1";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([
            ':product_name' => $product,
            ':size'         => $size,
            ':color'        => $color
        ]);

        $productData = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$productData || $productData['quantity'] < $quantity) {
            die("❌ Not enough stock available.");
        }

        $order_sql = "INSERT INTO orders
                      (user_id, product_name, size, color, quantity, total_price, status, order_date)
                      VALUES
                      (:user_id, :product_name, :size, :color, :quantity, :total_price, :status, NOW())";

        $order_stmt = $pdo->prepare($order_sql);
        $order_stmt->execute([
            ':user_id'      => $_SESSION['user'],
            ':product_name' => $product,
            ':size'         => $size,
            ':color'        => $color,
            ':quantity'     => $quantity,
            ':total_price'  => $total,
            ':status'       => 'Pending',
        ]);

        $update_sql = "UPDATE products
                       SET quantity = quantity - :quantity
                       WHERE name = :product_name
                       AND FIND_IN_SET(:size, sizes) > 0
                       AND FIND_IN_SET(:color, colors) > 0";

        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([
            ':quantity'     => $quantity,
            ':product_name' => $product,
            ':size'         => $size,
            ':color'        => $color
        ]);

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
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
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                color: #333;
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
        </style>
    </head>
    <body>
        <div class="container">
            <h2>✅ Purchase Confirmed!</h2>
            <p>
                Product: <span class="highlight"><?= htmlspecialchars($product) ?></span><br>
                Size: <span class="highlight"><?= htmlspecialchars($size) ?></span><br>
                Color: <span class="highlight"><?= htmlspecialchars($color) ?></span><br>
                Quantity: <span class="highlight"><?= $quantity ?></span><br>
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
exit;
?>
