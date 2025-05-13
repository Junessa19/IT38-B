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
    <title>Sales</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; display: flex; height: 100vh; }
        .sidebar {
            width: 250px;
            background: #8B6F3F;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
        }
        .logo { width: 70px; height: 70px; border-radius: 50%; background: white; }
        .menu { list-style: none; margin-top: 30px; }
        .menu li { margin: 15px 0; }
        .menu a {
            color: white;
            text-decoration: none;
            padding: 8px;
            display: block;
            border-radius: 5px;
        }
        .menu a:hover { background: rgba(255, 255, 255, 0.2); }
        .logout { margin-top: 30px; font-weight: bold; }
        .content {
            margin-left: 250px;
            flex-grow: 1;
            background: #C7A061;
            min-height: 100vh;
        }
        .topbar {
            background: #8B6F3F;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
        }
        .dashboard-content {
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
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

        .sub-button {
            background-color: #C7A061;
            border: none;
            color: #333;
            padding: 10px;
            margin: 5px 0;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: left;
        }
        .sub-button:hover {
            background-color: #b48f4e;
        }

        .sales-result {
            padding: 10px 0;
            margin-left: 20px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <img src="logo.png" alt="Logo" class="logo">
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
                echo "Total Sales: ₱" . number_format($data1['total_sales'] ?? 0, 2);
                ?>
            </div>
        </div>

       <div class="card">
            <button class="collapsible">📅 Sales by Date</button>
            <div class="content-section">
                <button class="sub-button" onclick="toggleSection('month')">📆 Sales by Month</button>
                <div id="month" class="sales-result" style="display:none;">
                    <?php
                    $resMonth = $conn->query("
                        SELECT YEAR(order_date) AS year, MONTH(order_date) AS month, 
                        SUM(total_price) AS total_sales_by_month 
                        FROM orders 
                        GROUP BY year, month 
                        ORDER BY year DESC, month DESC
                    ");
                    while ($data = $resMonth->fetch_assoc()) {
                        echo "Month {$data['month']} of {$data['year']}: ₱" . number_format($data['total_sales_by_month'], 2) . "<br>";
                    }
                    ?>
                </div>

                <button class="sub-button" onclick="toggleSection('week')">🗓️ Sales by Week</button>
                <div id="week" class="sales-result" style="display:none;">
                    <?php
                    $resWeek = $conn->query("
                        SELECT YEAR(order_date) AS year, WEEK(order_date, 1) AS week, 
                        SUM(total_price) AS total_sales_by_week 
                        FROM orders 
                        GROUP BY year, week 
                        ORDER BY year DESC, week DESC
                    ");
                    while ($data = $resWeek->fetch_assoc()) {
                        echo "Week {$data['week']} of {$data['year']}: ₱" . number_format($data['total_sales_by_week'], 2) . "<br>";
                    }
                    ?>
                </div>
            </div>
        </div>

        
        <div class="card">
            🛒 Customer Orders
            <br><br>
            <a href="customer_orders.php" class="sub-button" style="background:#8B6F3F; color:white;">View Orders</a>
        </div>

    </div>
</div>

<script>
   
    var coll = document.getElementsByClassName("collapsible");
    for (let i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function () {
            this.classList.toggle("active");
            let content = this.nextElementSibling;
            content.style.display = content.style.display === "block" ? "none" : "block";
        });
    }

    
    function toggleSection(id) {
        const elem = document.getElementById(id);
        elem.style.display = elem.style.display === "block" ? "none" : "block";
    }
</script>
</body>
</html>
