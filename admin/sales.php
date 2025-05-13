<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include '../user/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #8B6F3F;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
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
            display: flex;
            align-items: center;
            font-size: 16px;
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
        }
        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            background: #C7A061;
            min-height: 100vh;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #8B6F3F;
            padding: 15px;
            color: white;
            width: 100%;
        }
        .search-bar {
            padding: 8px;
            border-radius: 5px;
            border: none;
            width: 200px;
        }
        .dashboard-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            min-height: 220px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 18px;
            font-weight: bold;
            position: relative;
        }
        .view-button, .collapsible {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #8B6F3F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .view-button:hover, .collapsible:hover {
            background-color: #6e4c2f;
        }
        .collapsible:after {
            content: ' ▼';
            float: right;
        }
        .active:after {
            content: ' ▲';
        }
        .content-section {
            visibility: hidden;
            height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .content-section.show {
            visibility: visible;
            height: auto;
        }
        .sales-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        .sales-result {
            flex: 1;
            background: #f7f7f7;
            padding: 15px;
            border-radius: 10px;
            font-weight: normal;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #8B6F3F;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <img src="logo.png" alt="Logo" class="logo">
        </div>
        <ul class="menu">
            <li><a href="dashboard.php">🏠 Home</a></li>
            <li><a href="inventory.php">📦 Inventory</a></li>
            <li><a href="sales.php">📈 Sales</a></li>
            <li><a href="suppliers.php">🚚 Suppliers</a></li>
            <li><a href="reports.php">📊 Reports</a></li>
        </ul>
        <a href="logout.php" class="logout">🚪 Logout</a>
    </div>

    <div class="content">
        <div class="topbar">
            <h2>📈 Sales</h2>
            <input type="text" class="search-bar" placeholder="Search...">
        </div>

        <div class="dashboard-content">

            <div class="card">
                <button class="collapsible">🧾 Sales Overview</button>
                <div class="content-section">
                    <?php
                    $res1 = $conn->query("SELECT SUM(total_price) AS total_sales FROM orders");
                    $data1 = $res1->fetch_assoc();
                    echo "Total Sales: ₱" . number_format($data1['total_sales'], 2);
                    ?>
                </div>
            </div>

            <div class="card">
                <button class="collapsible">📅 Sales by Date</button>
                <div class="content-section">
                    <div class="sales-container">
                        <div class="sales-result">
                            <h3>🗓️ Weekly Sales</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Week</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $resWeek = $conn->query("SELECT SUM(total_price) AS total_sales_week, WEEK(order_date) AS week, YEAR(order_date) AS year FROM orders GROUP BY year, week ORDER BY year DESC, week DESC");
                                    while ($row = $resWeek->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['year']}</td>
                                                <td>{$row['week']}</td>
                                                <td>₱" . number_format($row['total_sales_week'], 2) . "</td>
                                            </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="sales-result">
                            <h3>📆 Monthly Sales</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $resMonth = $conn->query("SELECT SUM(total_price) AS total_sales_month, DATE_FORMAT(order_date, '%Y-%m') AS month FROM orders GROUP BY month ORDER BY month DESC");
                                    while ($row = $resMonth->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['month']}</td>
                                                <td>₱" . number_format($row['total_sales_month'], 2) . "</td>
                                            </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <button class="collapsible">🛒 Customer Orders</button>
                <div class="content-section" id="customerOrdersSection">
                    <div class="sales-table">
                        <h3>🧾 Order List</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $orders = $conn->query("SELECT orders.id, users.username, orders.order_date, orders.total_price FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.order_date DESC");
                                while ($row = $orders->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['username']}</td>
                                            <td>{$row['order_date']}</td>
                                            <td>";

                                    $order_id = $row['id'];
                                    $items = $conn->query("SELECT product_name, quantity FROM order_items WHERE order_id = $order_id");
                                    $item_list = [];
                                    while ($item = $items->fetch_assoc()) {
                                        $item_list[] = $item['product_name'] . ' (x' . $item['quantity'] . ')';
                                    }
                                    echo implode(', ', $item_list);

                                    echo "</td>
                                            <td>₱" . number_format($row['total_price'], 2) . "</td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        var coll = document.getElementsByClassName("collapsible");
        for (var i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                content.classList.toggle("show");
            });
        }
    </script>
</body>
</html>
