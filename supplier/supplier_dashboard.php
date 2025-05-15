<?php
include __DIR__ . '/../db_connection.php';

$supplier_id = 1; // Replace this with session logic when available

// Optional: Insert sample 50 products if needed (only once)
$check = mysqli_query($conn, "SELECT COUNT(*) as total FROM supplier_products WHERE supplier_id = $supplier_id");
$row = mysqli_fetch_assoc($check);
if ($row['total'] == 0) {
    $sample_products = [
      [
    ["Cardigan", ["S", "M", "L", "XL"], ["Beige", "Light Blue"], "Forever 21", 15, 28, "cardigan.jpg"],
    ["Turtle Neck", ["M", "L"], ["Black", "White", "Grey"], "Uniqlo", 12, 30, "turtle_neck.jpg"],
    ["Joggers", ["S", "M", "L", "XL"], ["Charcoal", "Blue"], "Nike", 20, 40, "joggers.jpg"],
    ["Polo Shirt", ["S", "M", "L", "XL"], ["White", "Navy", "Red"], "Tommy Hilfiger", 18, 35, "polo_shirt.jpg"],
    ["Blouse", ["S", "M", "L"], ["Pink", "White", "Peach"], "H&M", 22, 25, "blouse.jpg"],
    ["Denim Jacket", ["S", "M", "L"], ["Light Blue", "Dark Blue"], "Levi's", 8, 60, "denim_jacket.jpg"],
    ["Track Pants", ["M", "L", "XL"], ["Black", "Grey"], "Adidas", 25, 20, "track_pants.jpg"],
    ["Chinos", ["28", "30", "32", "34"], ["Tan", "Black", "Navy"], "Gap", 30, 45, "chinos.jpg"],
    ["Tunic Dress", ["S", "M", "L"], ["Floral", "Solid Black"], "Zara", 5, 38, "tunic_dress.jpg"],
    ["Maxi Skirt", ["S", "M", "L"], ["Black", "Red"], "H&M", 0, 20, "maxi_skirt.jpg"],
    ["Sweatshirt", ["M", "L", "XL"], ["Gray", "Maroon"], "Puma", 10, 50, "sweatshirt.jpg"],
    ["Leggings", ["S", "M", "L", "XL"], ["Black", "Gray"], "Fabletics", 35, 22, "leggings.jpg"],
    ["Romper", ["S", "M", "L"], ["Blue", "White"], "Shein", 18, 28, "romper.jpg"],
    ["Knit Top", ["S", "M", "L"], ["Cream", "Pink"], "Zara", 12, 30, "knit_top.jpg"],
    ["Button-Down Shirt", ["S", "M", "L"], ["White", "Light Blue"], "Ralph Lauren", 20, 40, "button_down_shirt.jpg"],
    ["Plaid Shirt", ["S", "M", "L"], ["Red", "Black"], "Abercrombie", 15, 35, "plaid_shirt.jpg"],
    ["Short Dress", ["S", "M", "L"], ["Black", "Navy"], "ASOS", 25, 38, "short_dress.jpg"],
    ["Peacoat", ["S", "M", "L"], ["Navy", "Black"], "Uniqlo", 8, 80, "peacoat.jpg"],
    ["V-Neck T-Shirt", ["S", "M", "L"], ["White", "Black", "Blue"], "H&M", 28, 18, "v_neck_tshirt.jpg"],
    ["Flannel Shirt", ["M", "L"], ["Red", "Green"], "American Eagle", 7, 40, "flannel_shirt.jpg"],
    ["Bomber Jacket", ["S", "M", "L"], ["Olive", "Black"], "Superdry", 18, 55, "bomber_jacket.jpg"],
    ["Bodysuit", ["S", "M", "L"], ["Black", "White", "Nude"], "Aerie", 22, 25, "bodysuit.jpg"],
    ["Puffer Jacket", ["M", "L", "XL"], ["Black", "Gray"], "Patagonia", 5, 90, "puffer_jacket.jpg"],
    ["Blouson", ["S", "M", "L"], ["Burgundy", "Navy"], "Lacoste", 12, 50, "blouson.jpg"],
    ["Kimono", ["S", "M", "L"], ["Floral", "Black"], "Mango", 0, 45, "kimono.jpg"],
    ["Culottes", ["S", "M", "L"], ["Tan", "Olive"], "Bershka", 10, 30, "culottes.jpg"],
    ["Tank Top", ["S", "M", "L"], ["White", "Pink", "Blue"], "H&M", 15, 15, "tank_top.jpg"],
    ["Skater Skirt", ["S", "M", "L"], ["Black", "Blue"], "Forever 21", 8, 20, "skater_skirt.jpg"],
    ["Harem Pants", ["S", "M", "L"], ["Black", "Beige"], "Boohoo", 20, 25, "harem_pants.jpg"],
    ["Peasant Blouse", ["S", "M", "L"], ["White", "Light Green"], "Free People", 25, 28, "peasant_blouse.jpg"],
    ["Palazzo Pants", ["S", "M", "L"], ["Black", "White"], "Zara", 10, 40, "palazzo_pants.jpg"],
    ["Mini Skirt", ["S", "M", "L"], ["Black", "Pink"], "Topshop", 15, 18, "mini_skirt.jpg"],
    ["Trench Coat", ["S", "M", "L"], ["Camel", "Black"], "Burberry", 5, 120, "trench_coat.jpg"],
    ["Pinafore Dress", ["S", "M", "L"], ["Blue", "Black"], "Urban Outfitters", 9, 45, "pinafore_dress.jpg"],
    ["Biker Shorts", ["S", "M", "L"], ["Black", "Gray"], "Aerie", 30, 15, "biker_shorts.jpg"],
    ["Shacket", ["S", "M", "L"], ["Plaid", "Navy"], "H&M", 20, 50, "shacket.jpg"],
    ["Wide-Leg Pants", ["S", "M", "L"], ["Black", "Tan"], "H&M", 17, 40, "wide_leg_pants.jpg"],
    ["Bikini", ["S", "M", "L"], ["Red", "Blue"], "Triangl", 25, 45, "bikini.jpg"],
    ["Sarong", ["One Size"], ["Blue", "Purple"], "Forever 21", 10, 12, "sarong.jpg"],
    ["Slip Dress", ["S", "M", "L"], ["Black", "White"], "Zara", 18, 60, "slip_dress.jpg"],
    ["Chanel Dress", ["S", "M", "L"], ["Black", "White"], "Chanel", 3, 300, "chanel_dress.jpg"],
    ["Slip Skirt", ["S", "M", "L"], ["Nude", "Black"], "H&M", 8, 25, "slip_skirt.jpg"],
    ["Midi Skirt", ["S", "M", "L"], ["Pink", "Yellow"], "ASOS", 15, 35, "midi_skirt.jpg"],
    ["Hooded Sweatshirt", ["S", "M", "L", "XL"], ["Gray", "Navy"], "Hollister", 30, 25, "hooded_sweatshirt.jpg"],
    ["Vest Top", ["S", "M", "L"], ["Black", "White"], "Primark", 12, 18, "vest_top.jpg"],
    ["Cargo Pants", ["S", "M", "L", "XL"], ["Black", "Olive"], "American Eagle", 22, 32, "cargo_pants.jpg"],
    ["Terry Cloth Dress", ["S", "M", "L"], ["White", "Navy"], "Aerie", 10, 50, "terry_cloth_dress.jpg"],
    ["Windbreaker", ["M", "L", "XL"], ["Red", "Blue"], "Nike", 0, 55, "windbreaker.jpg"],
    ["Overalls", ["S", "M", "L"], ["Blue", "Black"], "Levi's", 20, 40, "overalls.jpg"],
    ["Tight Fit Jeans", ["28", "30", "32"], ["Black", "Dark Blue"], "Lee", 18, 35, "tight_fit_jeans.jpg"],
    ["Sheer Blouse", ["S", "M", "L"], ["Pink", "Black"], "Express", 12, 30, "sheer_blouse.jpg"],
    ["Puffer Vest", ["M", "L", "XL"], ["Black", "Gray"], "Patagonia", 8, 50, "puffer_vest.jpg"],
    ["Sweater Dress", ["S", "M", "L"], ["Gray", "Blue"], "Uniqlo", 15, 55, "sweater_dress.jpg"]
]
    ];

    for ($i = 1; $i <= 5; $i++) {
        foreach ($sample_products as $product) {
            $name = $product[0] . " $i";
            $size = $product[1][array_rand($product[1])];
            $color = $product[2][array_rand($product[2])];
            $brand = $product[3];
            $price = $product[4];
            $quantity = $product[5];
            $image = $product[6];

            $stmt = $conn->prepare("INSERT INTO supplier_products (supplier_id, product_name, size, color, brand, price, available_quantity, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssdis", $supplier_id, $name, $size, $color, $brand, $price, $quantity, $image);
            $stmt->execute();
        }
    }
}

// Fetch products
$sql = "SELECT * FROM supplier_products WHERE supplier_id = $supplier_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Dashboard</title>
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
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: white;
            object-fit: cover;
        }
        .menu {
            list-style: none;
            padding: 20px 0;
        }
        .menu li {
            margin: 15px 0;
        }
        .menu a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            padding: 8px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .logout {
            margin-top: 30px;
            font-weight: bold;
            color: white;
            display: inline-block;
            text-decoration: none;
        }
        .main {
            margin-left: 250px;
            width: calc(100% - 250px);
            background: #C7A061;
            min-height: 250vh;
            padding: 20px;
        }
        h1, h2 {
            color: #fff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #8B6F3F;
            color: white;
        }
        table tr:hover {
            background-color: #f5f5f5;
        }
        a.action-link {
            color: #8B6F3F;
            font-weight: bold;
            text-decoration: none;
        }
        a.action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-container">
            <img src="logo.png" alt="Logo" class="logo">
        </div>
        <ul class="menu">
            <li><a href="supplier_dashboard.php">📋 Dashboard</a></li>
            <li><a href="add_product.php">➕ Add Product</a></li>
            <li><a href="handle_requests.php">📥 Handle Requests</a></li>
        </ul>
        <a href="../logout.php" class="logout">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h1>Supplier Dashboard</h1>

        <div id="Products">
            <h2>📦 Your Products</h2>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Available Qty</th>
                    <th>Actions</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['product_name']}</td>
                            <td>{$row['size']}</td>
                            <td>{$row['color']}</td>
                            <td>₱{$row['price']}</td>
                            <td>{$row['available_quantity']}</td>
                            <td>
                                <a class='action-link' href='edit_product.php?id={$row['id']}'>Edit</a> |
                                <a class='action-link' href='handle_requests.php?action=delete_product&id={$row['id']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>
</html>

<?php mysqli_close($conn); ?>
