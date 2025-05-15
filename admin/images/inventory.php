<?php
// Database connection details
$servername = "localhost";   // Usually localhost on XAMPP
$username = "root";          // Your MySQL username
$password = "";              // Your MySQL password (usually empty on XAMPP)
$dbname = "your_database";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Inventory</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }
    th {
        background-color: #b8860b;
        color: white;
    }
    select {
        padding: 5px;
        width: 100px;
    }
    img {
        width: 80px;
        height: auto;
        object-fit: contain;
    }
    .out-of-stock {
        color: red;
        font-weight: bold;
    }
</style>
</head>
<body>

<h2>Product Inventory</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Sizes</th>
            <th>Colors</th>
            <th>Brand</th>
            <th>Quantity</th>
            <th>Price ($)</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        while($item = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['id']) . "</td>";
            echo "<td>" . htmlspecialchars($item['product_name']) . "</td>";

            // Sizes dropdown
            echo "<td><select>";
            $sizes = explode(",", $item['sizes']);
            foreach ($sizes as $size) {
                echo "<option>" . htmlspecialchars(trim($size)) . "</option>";
            }
            echo "</select></td>";

            // Colors dropdown
            echo "<td><select>";
            $colors = explode(",", $item['colors']);
            foreach ($colors as $color) {
                echo "<option>" . htmlspecialchars(trim($color)) . "</option>";
            }
            echo "</select></td>";

            echo "<td>" . htmlspecialchars($item['brand']) . "</td>";

            // Quantity with out of stock notice
            if ((int)$item['quantity'] <= 0) {
                echo "<td class='out-of-stock'>Out of Stock</td>";
            } else {
                echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
            }

            echo "<td>" . number_format($item['price'], 2) . "</td>";

            // Image display (images must be inside 'images/' folder)
            $imagePath = "images/" . $item['image'];
            if (file_exists($imagePath)) {
                echo "<td><img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($item['product_name']) . "'></td>";
            } else {
                echo "<td>No Image</td>";
            }

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No products found.</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>
</table>

</body>
</html>
