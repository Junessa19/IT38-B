<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Database connection details
$host = 'localhost';
$db   = 'clothing_store';
$user = 'root';
$pass = '';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize messages
$error = '';
$success = '';

// Handle product addition POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $product_name = trim($_POST['product_name']);
    $sizes        = trim($_POST['sizes']);
    $colors       = trim($_POST['colors']);
    $brand        = trim($_POST['brand']);
    $quantity     = (int) $_POST['quantity'];
    $price        = (float) $_POST['price'];
    $image        = $_FILES['image']['name'];

    // Validate image upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'images/' . basename($image);
        move_uploaded_file($image_tmp, $image_path);
    } else {
        $image_path = '';
    }

    try {
        // Insert new product into the database
        $sql = "INSERT INTO products (product_name, sizes, colors, brand, quantity, price, image)
                VALUES (:product_name, :sizes, :colors, :brand, :quantity, :price, :image)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':product_name' => $product_name,
            ':sizes'        => $sizes,
            ':colors'       => $colors,
            ':brand'        => $brand,
            ':quantity'     => $quantity,
            ':price'        => $price,
            ':image'        => $image_path,
        ]);

        $success = "✅ Product '$product_name' added successfully.";
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}

// Fetch all products for inventory display
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filter out the product "T-Shirt"
$products = array_filter($products, function ($item) {
    return strtolower($item['product_name']) !== 't-shirt';
});
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
        margin-bottom: 40px;
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
    }
    th {
        background-color: #b8860b;
        color: white;
    }
    select, input[type=number], input[type=text], input[type=file] {
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
    .message {
        max-width: 600px;
        margin: 10px auto;
        padding: 15px;
        border-radius: 5px;
        text-align: center;
    }
    .error {
        background-color: #f8d7da;
        color: #842029;
    }
    .success {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    button {
        background-color: #b8860b;
        color: white;
        border: none;
        padding: 7px 15px;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #8b6600;
    }
</style>
</head>
<body>

<h2>Product Inventory</h2>

<?php if (!empty($error)) : ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <div class="message success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Sizes</th>
            <th>Colors</th>
            <th>Brand</th>
            <th>Quantity</th>
            <th>Price (₱)</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['id']) ?></td>
            <td><?= htmlspecialchars($item['product_name']) ?></td>
            <td><?= htmlspecialchars($item['sizes']) ?></td>
            <td><?= htmlspecialchars($item['colors']) ?></td>
            <td><?= htmlspecialchars($item['brand']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td>
                <?php
                $imagePath = "images/" . $item['image'];
                if (file_exists($imagePath) && !empty($item['image'])) {
                    echo "<img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($item['product_name']) . "'>";
                } else {
                    echo "No Image";
                }
                ?>
            </td>
            <td>
                <form style="display:inline;" method="GET" action="edit_product.php">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
                    <button type="submit">Edit</button>
                </form>
                <form style="display:inline;" method="POST" action="delete_product.php" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
                    <button type="submit" name="delete_product" style="background-color:#d9534f;">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

    <?php if (count($products) === 0): ?>
        <tr><td colspan="9">No products found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<h3>Add New Product</h3>
<form method="POST" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" required><br><br>
    <label for="sizes">Sizes (comma-separated):</label>
    <input type="text" name="sizes" required><br><br>
    <label for="colors">Colors (comma-separated):</label>
    <input type="text" name="colors" required><br><br>
    <label for="brand">Brand:</label>
    <input type="text" name="brand" required><br><br>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" min="0" required><br><br>
    <label for="price">Price (₱):</label>
    <input type="number" name="price" step="0.01" min="0" required><br><br>
    <label for="image">Image:</label>
    <input type="file" name="image" accept="image/*"><br><br>
    <button type="submit" name="add_product">Add Product</button>
</form>

</body>
</html>
