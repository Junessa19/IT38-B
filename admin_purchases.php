<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";  // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch purchase records
$sql = "SELECT p.id, u.username, p.product, p.size, p.color, p.quantity, p.price, p.total, p.purchase_date
        FROM purchases p
        JOIN users u ON p.user_id = u.id
        ORDER BY p.purchase_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Purchases</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f6e9d7;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #5a3e1b;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>🛒 User Purchase Records</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Product</th>
            <th>Size</th>
            <th>Color</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Purchase Date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['username']) . "</td>
                        <td>" . htmlspecialchars($row['product']) . "</td>
                        <td>" . htmlspecialchars($row['size']) . "</td>
                        <td>" . htmlspecialchars($row['color']) . "</td>
                        <td>" . $row['quantity'] . "</td>
                        <td>₱" . number_format($row['price'], 2) . "</td>
                        <td>₱" . number_format($row['total'], 2) . "</td>
                        <td>" . $row['purchase_date'] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No purchases found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>

