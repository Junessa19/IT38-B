<?php include '../db_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product - Supplier</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
    }
    .sidebar {
      width: 250px;
      background: #8B6F3F;
      color: white;
      padding: 20px;
      position: fixed;
      height: 100vh;
    }
    .logo-container {
      margin-bottom: 20px;
    }
    .logo-container h2 {
      font-size: 28px;
      color: white;
    }
    .menu {
      list-style: none;
      padding: 20px 0;
    }
    .menu a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      display: block;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 10px;
      background: rgba(255, 255, 255, 0.1);
      transition: 0.3s;
    }
    .menu a:hover, .menu a.active {
      background: rgba(255, 255, 255, 0.3);
    }
    .logout {
      margin-top: 30px;
      font-weight: bold;
      display: inline-block;
      color: white;
      text-decoration: none;
    }
    .main {
      margin-left: 250px;
      width: calc(100% - 250px);
      background: #C7A061;
      min-height: 100vh;
      padding: 40px 20px;
    }
    h1 {
      color: white;
      margin-bottom: 20px;
    }
    form {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      max-width: 500px;
    }
    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      padding: 10px 20px;
      background-color: #8B6F3F;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #A57A45;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <div class="logo-container">
      <h2>StockHub</h2>
    </div>
    <div class="menu">
      <a href="supplier_dashboard.php">📋 Dashboard</a>
      <a href="add_product.php" class="active">➕ Add Product</a>
      <a href="handle_requests.php">📥 Handle Requests</a>
    </div>
    <a href="../logout.php" class="logout">🚪 Logout</a>
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
