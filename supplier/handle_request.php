<?php
include __DIR__ . '/../db_connection.php';

// UPDATE PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_product') {
    $product_id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    $sql = "UPDATE supplier_products SET 
                product_name = '$name',
                size = '$size',
                color = '$color',
                price = $price,
                available_quantity = $quantity
            WHERE id = $product_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: supplier_dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// DELETE PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_product' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    $sql = "DELETE FROM supplier_products WHERE id = $product_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: supplier_dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
