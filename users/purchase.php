<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product = $_POST["product"];
    $size = $_POST["size"];
    $color = $_POST["color"];
    $quantity = (int)$_POST["quantity"];
    $price = (float)$_POST["price"];
    $total = $quantity * $price;

    // Here you would store purchase to database (optional)
    echo "<h2>✅ Purchase Confirmed!</h2>";
    echo "<p>Product: <strong>$product</strong><br>";
    echo "Size: $size<br>";
    echo "Color: $color<br>";
    echo "Quantity: $quantity<br>";
    echo "Total: ₱" . number_format($total, 2) . "</p>";
    echo "<a href='user_dashboard.php'>⬅ Back to Dashboard</a>";
} else {
    header("Location: user_dashboard.php");
    exit();
}
?>
