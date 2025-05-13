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
            min-height: 280vh;
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
        .view-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #8B6F3F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .view-button:hover {
            background-color: #6e4c2f;
        }
        .collapsible {
            cursor: pointer;
            padding: 10px;
            background-color: #8B6F3F;
            color: white;
            border: none;
            width: 100%;
            text-align: left;
            border-radius: 5px;
            font-size: 18px;
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
        .sales-result {
            display: none;
        }
        .sales-result.show {
            display: flex;
            gap: 30px;
            justify-content: space-between;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .sales-table {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            flex: 1;
            min-width: 300px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .sales-table h3 {
            margin-bottom: 10px;
            color: #8B6F3F;
            font-size: 18px;
            border-bottom: 2px solid #C7A061;
            padding-bottom: 5px;
        }
        .sales-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .sales-table th, .sales-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .sales-table th {
            background-color: #f4e1c1;
            color: #5b4223;
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
                    if ($res1->num_rows > 0) {
                        $data1 = $res1->fetch_assoc();
                        $total_sales = $data1['total_sales'] ?? 0;
                        echo "Total Sales: ₱" . number_format($total_sales, 2);
                    } else {
                        echo "Error retrieving sales data.";
                    }
                    ?>
                </div>
            </div>

            <div class="card">
                <button class="collapsible">📅 Sales by Date</button>
                <div class="content-section">
                    <button class="view-button" onclick="toggleSales()">Show Sales</button>

                    <div id="salesContainer" class="sales-result">
                        <div class="sales-table">
                            <h3>🗓️ Weekly Sales</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Week</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $resWeek = $conn->query("SELECT SUM(total_price) AS total_sales_week, WEEK(order_date) AS week, YEAR(order_date) AS year FROM orders GROUP BY year, week ORDER BY year DESC, week DESC");
                                    if ($resWeek->num_rows > 0) {
                                        while ($row = $resWeek->fetch_assoc()) {
                                            echo "<tr><td>{$row['year']}</td><td>{$row['week']}</td><td>₱" . number_format($row['total_sales_week'], 2) . "</td></tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No weekly sales data.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="sales-table">
                            <h3>📆 Monthly Sales</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $resMonth = $conn->query("SELECT SUM(total_price) AS total_sales_month, DATE_FORMAT(order_date, '%Y-%m') AS month FROM orders GROUP BY month ORDER BY month DESC");
                                    if ($resMonth->num_rows > 0) {
                                        while ($row = $resMonth->fetch_assoc()) {
                                            echo "<tr><td>{$row['month']}</td><td>₱" . number_format($row['total_sales_month'], 2) . "</td></tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='2'>No monthly sales data.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
    🛒 Customer Orders
    <br><br>
    <a href="customer_orders.php" class="view-button">View</a>
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

        function toggleSales() {
            var salesDiv = document.getElementById("salesContainer");
            salesDiv.classList.toggle("show");
        }
    </script>
</body>
</html>
