<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $id = (int) $_POST['id'];

    $host = 'localhost';
    $db   = 'clothing_store';
    $user = 'root';
    $pass = '';
    $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Optionally, delete the image file from server before deleting product record
        $stmtImg = $pdo->prepare("SELECT image FROM products WHERE id = :id");
        $stmtImg->execute([':id' => $id]);
        $product = $stmtImg->fetch(PDO::FETCH_ASSOC);

        if ($product && !empty($product['image']) && file_exists($product['image'])) {
            unlink($product['image']);
        }

        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);

        header('Location: inventory.php?msg=deleted');
        exit();

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header('Location: inventory.php');
    exit();
}
