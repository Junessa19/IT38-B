<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

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

$error = '';
$success = '';

if (!isset($_GET['id']) && !isset($_POST['id'])) {
    die("Invalid request.");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_POST['id'];

// Handle update POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_name = trim($_POST['product_name']);
    $sizes        = trim($_POST['sizes']);
    $colors       = trim($_POST['colors']);
    $brand        = trim($_POST['brand']);
    $quantity     = (int) $_POST['quantity'];
    $price        = (float) $_POST['price'];

    try {
        // If new image uploaded, handle upload
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_name = basename($_FILES['image']['name']);
            $image_path = 'images/' . $image_name;
            move_uploaded_file($image_tmp, $image_path);
        }

        // Build query dynamically to update image only if uploaded
        if ($image_path) {
            $sql = "UPDATE products SET product_name=:product_name, sizes=:sizes, colors=:colors, brand=:brand, quantity=:quantity, price=:price, image=:image WHERE id=:id";
        } else {
            $sql = "UPDATE products SET product_name=:product_name, sizes=:sizes, colors=:colors, brand=:brand, quantity=:quantity, price=:price WHERE id=:id";
        }

        $stmt = $pdo->prepare($sql);

        $params = [
            ':product_name' => $product_name,
            ':sizes'        => $sizes,
            ':colors'       => $colors,
            ':brand'        => $brand,
            ':quantity'     => $quantity,
            ':price'        => $price,
            ':id'           => $id,
        ];

        if ($image_path) {
            $params[':image'] = $image_path;
        }

        $stmt->execute($params);

        $success = "✅ Product updated successfully.";
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}

// Fetch product data to fill the form
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Edit Product</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; }
    form { max-width: 500px; background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
    label { display: block; margin-top: 15px; }
    input[type=text], input[type=number], input[type=file] { width: 100%; padding: 8px; margin-top: 5px; }
    button { margin-top: 20px; background-color: #b8860b; color: white; border: none; padding: 10px; cursor: pointer; border-radius: 4px; }
    button:hover { background-color: #8b6600; }
    .message { margin: 15px 0; padding: 10px; border-radius: 5px; }
    .error { background: #f8d7da; color: #842029; }
    .success { background: #d1e7dd; color: #0f5132; }
    img { max-width: 150px; margin-top: 10px; }
    a { display: inline-block; margin-top: 20px; text-decoration: none; color: #b8860b; }
</style>
</head>
<body>

<h2>Edit Product</h2>

<?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="message success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

    <label>Product Name:</label>
    <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>

    <label>Sizes (comma-separated):</label>
    <input type="text" name="sizes" value="<?= htmlspecialchars($product['sizes']) ?>" required>

    <label>Colors (comma-separated):</label>
    <input type="text" name="colors" value="<?= htmlspecialchars($product['colors']) ?>" required>

    <label>Brand:</label>
    <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>

    <label>Quantity:</label>
    <input type="number" name="quantity" min="0" value="<?= htmlspecialchars($product['quantity']) ?>" required>

    <label>Price (₱):</label>
    <input type="number" name="price" step="0.01" min="0" value="<?= htmlspecialchars($product['price']) ?>" required>

    <label>Current Image:</label><br>
    <?php if (!empty($product['image']) && file_exists($product['image'])): ?>
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="Current Image">
    <?php else: ?>
        No Image
    <?php endif; ?>

    <label>Upload New Image (optional):</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit" name="update_product">Update Product</button>
</form>

<a href="inventory.php">← Back to Inventory</a>

</body>
</html>
