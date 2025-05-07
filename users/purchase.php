<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include "db.php"; // Make sure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user"];
    $product = $_POST["product"];
    $size = $_POST["size"];
    $color = $_POST["color"];
    $quantity = (int)$_POST["quantity"];
    $price = (float)$_POST["price"];
    $total = $quantity * $price;

    // Store to database
    $stmt = $conn->prepare("INSERT INTO purchases (user_id, product, size, color, quantity, price, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssidd", $user_id, $product, $size, $color, $quantity, $price, $total);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Confirmation</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background: #C7A061;
            padding: 40px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #5a3e1b;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            line-height: 1.6;
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
        .highlight {
            font-weight: bold;
            color: #333;
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
        <a class="back" href="user_dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
