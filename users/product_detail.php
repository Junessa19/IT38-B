<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$product = $_GET["product"] ?? "Unknown";

// Simulated product data (can replace with DB query)
$products = [
    "T-Shirt" => [
        "sizes" => ["S", "M", "L", "XL"],
        "colors" => ["Black", "White", "Red", "Blue", "Green", "Yellow", "Pink", "Gray"],
        "price" => 10,
        "available" => 50,
        "image" => "tshirt.jpg"
    ],
    // Repeat similar structure for Jeans, Skirt, etc...
];

$data = $products[$product] ?? null;

if (!$data) {
    echo "Product not found!";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product) ?> Details</title>
    <style>
        body {
            font-family: Arial;
            background: #f8f0e3;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        h2 {
            color: #5a3e1b;
            margin-bottom: 10px;
        }
        form select, input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background: #8B6F3F;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #6b5430;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($product) ?></h2>
    <img src="images/<?= $data["image"] ?>" alt="<?= $product ?>">
    <form method="POST" action="purchase.php">
        <input type="hidden" name="product" value="<?= htmlspecialchars($product) ?>">
        <label>Size:</label>
        <select name="size" required>
            <option value="">Select Size</option>
            <?php foreach ($data["sizes"] as $s): ?>
                <option value="<?= $s ?>"><?= $s ?></option>
            <?php endforeach; ?>
        </select>

        <label>Color:</label>
        <select name="color" required>
            <option value="">Select Color</option>
            <?php foreach ($data["colors"] as $c): ?>
                <option value="<?= $c ?>"><?= $c ?></option>
            <?php endforeach; ?>
        </select>

        <label>Quantity (Max <?= $data["available"] ?>):</label>
        <input type="number" name="quantity" min="1" max="<?= $data["available"] ?>" required>

        <input type="hidden" name="price" value="<?= $data["price"] ?>">

        <button type="submit">Buy Now for ₱<?= number_format($data["price"], 2) ?></button>
    </form>
</div>
</body>
</html>
