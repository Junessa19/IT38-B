<?php
include __DIR__ . '/../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['action'] === 'update_product') {
    $product_id = $_POST['id'];
    $name = $_POST['product_name'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE supplier_products SET 
            product_name = '$name',
            size = '$size',
            color = '$color',
            price = '$price',
            available_quantity = '$quantity'
            WHERE id = $product_id";

    if (mysqli_query($conn, $sql)) {
      header("Location: supplier_dashboard.php");
      exit();
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }
}

if ($_GET['action'] === 'delete_product' && isset($_GET['id'])) {
  $product_id = $_GET['id'];
  $sql = "DELETE FROM supplier_products WHERE id = $product_id";

  if (mysqli_query($conn, $sql)) {
    header("Location: supplier_dashboard.php");
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>

<?php
mysqli_close($conn); // Close the database connection
?>
