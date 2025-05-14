<?php
include __DIR__ . '/../db_connection.php';

if (!isset($_GET['id'])) {
  die('Product ID is required.');
}

$product_id = $_GET['id'];
$sql = "SELECT * FROM supplier_products WHERE id = $product_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
  die('Product not found.');
}

$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product - Supplier</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>StockHub</h2>
    <a href="supplier_dashboard.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="handle_requests.php">Handle Requests</a>
    <a href="../logout.php">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main">
    <h1>Edit Product</h1>
    <form method="POST" action="handle_requests.php">
      <input type="text" name="product_name" value="<?= $product['product_name'] ?>" required><br>
      <input type="text" name="size" value="<?= $product['size'] ?>" required><br>
      <input type="text" name="color" value="<?= $product['color'] ?>" required><br>
      <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required><br>
      <input type="number" name="quantity" value="<?= $product['available_quantity'] ?>" required><br>
      <input type="hidden" name="action" value="update_product">
      <input type="hidden" name="id" value="<?= $product['id'] ?>">
      <button type="submit">Update Product</button>
    </form>
  </div>

</body>
</html>

<?php
mysqli_close($conn); // Close the database connection
?>
