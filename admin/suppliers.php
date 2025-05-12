<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
    <style>
       
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; display: flex; height: 100vh; }
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
        .logo-container { display: flex; align-items: center; gap: 10px; }
        .logo { width: 70px; height: 70px; border-radius: 50%; background: white; object-fit: cover; }
        .menu { list-style: none; padding: 20px 0; }
        .menu li { margin: 15px 0; }
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
        .menu a:hover { background: rgba(255, 255, 255, 0.2); }
        .logout { margin-top: 30px; font-weight: bold; }
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
            grid-template-columns: repeat(3, 1fr);
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
            <h2>🚚 Suppliers</h2>
            <input type="text" class="search-bar" placeholder="Search...">
        </div>
        <div class="dashboard-content">
            <div class="card">📋 Supplier List</div>
            <div class="card">📝 Supplier Orders</div>
            <div class="card">📦 Deliveries Received</div>
        </div>
    </div>
</body>
</html>
