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
            box-sizing: border-box;
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            min-height: 150px;
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
            display: none;
            padding: 10px;
            margin-top: 10px;
            text-align: left;
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
                <button class="collapsible">📅 Sales by Month</button>
                <div class="content-section">
                    <?php
                    $resMonth = $conn->query("
                        SELECT 
                            YEAR(order_date) AS year, 
                            MONTH(order_date) AS month, 
                            SUM(total_price) AS total_sales_by_month 
                        FROM orders 
                        GROUP BY year, month 
                        ORDER BY year DESC, month DESC
                    ");
                    if ($resMonth->num_rows > 0) {
                        while ($data = $resMonth->fetch_assoc()) {
                            echo "<br>Month " . $data['month'] . " of " . $data['year'] . " - ₱" . number_format($data['total_sales_by_month'], 2);
                        }
                    } else {
                        echo "No monthly sales data.";
                    }
                    ?>
                </div>
            </div>

            <!-- Sales by Week -->
            <div class="card">
                <button class="collapsible">🗓️ Sales by Week</button>
                <div class="content-section">
                    <?php
                    $resWeek = $conn->query("
                        SELECT 
                            YEAR(order_date) AS year, 
                            WEEK(order_date, 1) AS week, 
                            SUM(total_price) AS total_sales_by_week 
                        FROM orders 
                        GROUP BY year, week 
                        ORDER BY year DESC, week DESC
                    ");
                    if ($resWeek->num_rows > 0) {
                        while ($data = $resWeek->fetch_assoc()) {
                            echo "<br>Week " . $data['week'] . " of " . $data['year'] . " - ₱" . number_format($data['total_sales_by_week'], 2);
                        }
                    } else {
                        echo "No weekly sales data.";
                    }
                    ?>
                </div>
            </div>

            <!-- Customer Orders -->
            <div class="card">
                🛒 Customer Orders
                <br><br>
                <a href="customer_orders.php" class="view-button">View</a>
            </div>
        </div>
    </div>

    <script>
        var coll = document.getElementsByClassName("collapsible");
        for (var i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    </script>
</body>
</html>
