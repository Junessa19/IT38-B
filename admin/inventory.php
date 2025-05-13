<?php
session_start();
// Uncomment this if login system is active
// if (!isset($_SESSION["user"])) {
//     header("Location: login.php");
//     exit();
// }

$products = [
    ["T-Shirt", ["S", "M", "L"], ["Black", "White"], "Uniqlo", 50, 10],
    ["Jeans", ["28", "30", "32"], ["Blue", "Black"], "Levi's", 30, 25],
    ["Skirt", ["S", "M", "L"], ["Red", "Blue"], "Zara", 0, 15],
    ["Crop Top", ["XS", "S", "M"], ["White", "Pink"], "H&M", 8, 12],
    ["Trouser", ["30", "32", "34"], ["Gray", "Beige"], "Gap", 35, 20],
    ["Jacket", ["M", "L", "XL"], ["Black", "Gray"], "North Face", 5, 50],
    ["Blazer", ["S", "M", "L"], ["Navy", "Gray"], "Zalora", 25, 40],
    ["Shorts", ["28", "30", "32"], ["Khaki", "Olive"], "Bench", 12, 18],
    ["Sweater", ["S", "M", "L"], ["Green", "Maroon"], "Penshoppe", 9, 22],
    ["Hoodie", ["M", "L", "XL"], ["Black", "Red"], "Adidas", 0, 35],
    ["Leggings", ["S", "M", "L"], ["Black", "Purple"], "Nike", 15, 30],
    ["Blouse", ["XS", "S", "M"], ["Peach", "Cream"], "Forever 21", 18, 28],
    ["Polo Shirt", ["S", "M", "L"], ["White", "Blue"], "Lacoste", 22, 32],
    ["Tank Top", ["XS", "S", "M"], ["Yellow", "White"], "H&M", 11, 14],
    ["Cardigan", ["S", "M", "L"], ["Beige", "Gray"], "Zara", 6, 24],
    ["Denim Jacket", ["M", "L", "XL"], ["Denim", "Black"], "Levi's", 13, 48],
    ["Tracksuit", ["M", "L", "XL"], ["Gray", "Navy"], "Adidas", 20, 55],
    ["Overalls", ["S", "M", "L"], ["Blue", "Dark Blue"], "Gap", 4, 42],
    ["Raincoat", ["S", "M", "L"], ["Yellow", "Transparent"], "Uniqlo", 2, 36],
    ["Kimono", ["One Size"], ["Pink", "Floral"], "Japan Style", 7, 38]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StockHub Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        select {
            padding: 5px;
        }
        .out-of-stock {
            color: red;
            font-weight: bold;
        }
        .back-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Available Products</h2>
    
    <!-- Back Button -->
    <button class="back-button" onclick="window.history.back()">Go Back</button>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Brand</th>
                <th>Available Sizes</th>
                <th>Available Colors</th>
                <th>Quantity</th>
                <th>Price (₱)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $index => $item): ?>
            <tr data-product-index="<?= $index ?>">
                <td><?= htmlspecialchars($item[0]) ?></td>
                <td><?= htmlspecialchars($item[3]) ?></td>
                <td>
                    <select class="size-dropdown">
                        <?php foreach ($item[1] as $size): ?>
                            <option value="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select class="color-dropdown">
                        <?php foreach ($item[2] as $color): ?>
                            <option value="<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($color) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class="<?= $item[4] <= 0 ? 'out-of-stock' : '' ?>">
                    <?= $item[4] <= 0 ? 'Out of Stock' : $item[4] ?>
                </td>
                <td>₱<?= number_format($item[5], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<script>
    const productData = <?php
        $data = [];
        foreach ($products as $index => $item) {
            $data["product_$index"] = [
                'sizes' => $item[1],
                'colors' => $item[2],
                'qty' => $item[4],
                'price' => $item[5]
            ];
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    ?>;

    console.log(productData); // You can inspect in browser dev tools
</script>

</body>
</html>
