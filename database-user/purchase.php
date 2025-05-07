// purchase.php
<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include "database-user/db.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"]; // Get user id from session
    $product = $_POST["product"];
    $size = $_POST["size"];
    $color = $_POST["color"];
    $quantity = (int)$_POST["quantity"];
    $price = (float)$_POST["price"];
    $total = $quantity * $price;

    // Store purchase information in the database
    $stmt = $conn->prepare("INSERT INTO purchases (user_id, product, size, color, quantity, price, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssidd", $user_id, $product, $size, $color, $quantity, $price, $total);
    $stmt->execute();
    $stmt->close();

    // Redirect to confirmation page
    header("Location: purchase_confirmation.php");
    exit();
}
?>
