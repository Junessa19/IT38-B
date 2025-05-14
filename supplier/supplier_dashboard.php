<?php include '../db_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Supplier Dashboard</title>
  <link rel="stylesheet" href="styles.css">
  <script>
    function openTab(tabId) {
      const contents = document.querySelectorAll(".tabcontent");
      const buttons = document.querySelectorAll(".tab button");
      contents.forEach(c => c.classList.remove("active"));
      buttons.forEach(b => b.classList.remove("active"));

      document.getElementById(tabId).classList.add("active");
      document.getElementById("btn-" + tabId).classList.add("active");
    }

    window.onload = () => openTab("Products");
  </script>
</head>
<body>

  <div class="sidebar">
    <div>
      <h2>StockHub</h2>
      <a href="supplier_dashboard.php" class="active">Dashboard</a>
      <a href="add_product.php">Add Product</a>
    </div>
    <a href="../logout.php">Logout</a>
  </div>

  <div class="main">
    <h1>Supplier Dashboard</h1>

    <div class="tab">
      <button id="btn-Products" onclick="openTab('Products')">Products</button>
      <button id="btn-Requests" onclick="openTab('Requests')">Requests</button>
      <button id="btn-Logistics" onclick="openTab('Logistics')">Logistics</button>
    </div>

    <div id="Products" class="tabcontent">
      <h2>Supplier Products</h2>
      <table>
        <tr><th>Product</th><th>Size</th><th>Color</th><th>Price</th><th>Available Qty</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM supplier_products");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$row['product_name']}</td>
            <td>{$row['size']}</td>
            <td>{$row['color']}</td>
            <td>₱{$row['price']}</td>
            <td>{$row['available_quantity']}</td>
          </tr>";
        }
        ?>
      </table>
    </div>

    <div id="Requests" class="tabcontent">
      <h2>Restock Requests</h2>
      <table>
        <tr><th>Product</th><th>Quantity</th><th>Date</th><th>Status</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM restock_requests");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$row['product_name']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['request_date']}</td>
            <td>{$row['status']}</td>
          </tr>";
        }
        ?>
      </table>
    </div>

    <div id="Logistics" class="tabcontent">
      <h2>Logistics</h2>
      <table>
        <tr><th>Request ID</th><th>Delivery Date</th><th>Status</th><th>Tracking #</th><th>Notes</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM logistics");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$row['request_id']}</td>
            <td>{$row['delivery_date']}</td>
            <td>{$row['status']}</td>
            <td>{$row['tracking_number']}</td>
            <td>{$row['notes']}</td>
          </tr>";
        }
        ?>
      </table>
    </div>
  </div>
</body>
</html>
<?php include '../db_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Supplier Dashboard</title>
  <link rel="stylesheet" href="styles.css">
  <script>
    function openTab(tabId) {
      const contents = document.querySelectorAll(".tabcontent");
      const buttons = document.querySelectorAll(".tab button");
      contents.forEach(c => c.classList.remove("active"));
      buttons.forEach(b => b.classList.remove("active"));

      document.getElementById(tabId).classList.add("active");
      document.getElementById("btn-" + tabId).classList.add("active");
    }

    window.onload = () => openTab("Products");
  </script>
</head>
<body>

  <div class="sidebar">
    <div>
      <h2>StockHub</h2>
      <a href="supplier_dashboard.php" class="active">Dashboard</a>
      <a href="add_product.php">Add Product</a>
    </div>
    <a href="../logout.php">Logout</a>
  </div>

  <div class="main">
    <h1>Supplier Dashboard</h1>

    <div class="tab">
      <button id="btn-Products" onclick="openTab('Products')">Products</button>
      <button id="btn-Requests" onclick="openTab('Requests')">Requests</button>
      <button id="btn-Logistics" onclick="openTab('Logistics')">Logistics</button>
    </div>

    <div id="Products" class="tabcontent">
      <h2>Supplier Products</h2>
      <table>
        <tr><th>Product</th><th>Size</th><th>Color</th><th>Price</th><th>Available Qty</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM supplier_products");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$row['product_name']}</td>
            <td>{$row['size']}</td>
            <td>{$row['color']}</td>
            <td>₱{$row['price']}</td>
            <td>{$row['available_quantity']}</td>
          </tr>";
        }
        ?>
      </table>
    </div>

    <div id="Requests" class="tabcontent">
      <h2>Restock Requests</h2>
      <table>
        <tr><th>Product</th><th>Quantity</th><th>Date</th><th>Status</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM restock_requests");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$row['product_name']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['request_date']}</td>
            <td>{$row['status']}</td>
          </tr>";
        }
        ?>
      </table>
    </div>

    <div id="Logistics" class="tabcontent">
      <h2>Logistics</h2>
      <table>
        <tr><th>Request ID</th><th>Delivery Date</th><th>Status</th><th>Tracking #</th><th>Notes</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM logistics");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$row['request_id']}</td>
            <td>{$row['delivery_date']}</td>
            <td>{$row['status']}</td>
            <td>{$row['tracking_number']}</td>
            <td>{$row['notes']}</td>
          </tr>";
        }
        ?>
      </table>
    </div>
  </div>
</body>
</html>
