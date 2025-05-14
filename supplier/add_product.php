<?php include '../db_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product - Supplier</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="sidebar">
    <div>
      <h2>StockHub</h2>
      <a href="supplier_dashboard.php">Dashboard</a>
      <a href="add_product.php" class="active">Add Product</a>
    </div>
    <a href="../logout.php">Logout</a>
  </div>

  <div class="main">
    <h1>Add New Product</h1>
    <form method="POST" action="handle_requests.php">
      <input type="text" name="product_name" placeholder="Product Name" required><br>
      <input type="text" name="size" placeholder="Size" required><br>
      <input type="text" name="color" placeholder="Color" required><br>
      <input type="number" name="price" placeholder="Price" step="0.01" required><br>
      <input type="number" name="quantity" placeholder="Available Quantity" required><br>
      <input type="hidden" name="action" value="add_product">
      <button type="submit">Add Product</button>
    </form>
  </div>
</body>
</html>
