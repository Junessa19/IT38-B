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
            padding: 20px;
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
        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
            color: #4b3d23;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #8B6F3F;
            color: white;
        }
        tr:hover {
            background-color: #f1e2ca;
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

        <h3>📋 Supplier List</h3>
        <table>
            <tr>
                <th>Supplier Name</th>
                <th>Contact Person</th>
                <th>Phone / Email</th>
                <th>Company Address</th>
                <th>Products Supplied</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td>Alpha Fabrics</td>
                <td>Jane Reyes</td>
                <td>0917-123-4567 / jane@alphafabrics.com</td>
                <td>Pasig City</td>
                <td>Textile, Buttons</td>
                <td>Active</td>
                <td>Edit | Delete</td>
            </tr>
        </table>

        <h3>📝 Supplier Orders</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Supplier Name</th>
                <th>Order Date</th>
                <th>Items Ordered</th>
                <th>Delivery Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td>ORD-0012</td>
                <td>Alpha Fabrics</td>
                <td>2025-05-10</td>
                <td>50m Cotton Fabric</td>
                <td>2025-05-15</td>
                <td>Pending</td>
                <td>View | Cancel</td>
            </tr>
        </table>

        <h3>📦 Deliveries Received</h3>
        <table>
            <tr>
                <th>Delivery ID</th>
                <th>Supplier Name</th>
                <th>Delivery Date</th>
                <th>Items Received</th>
                <th>Order Reference</th>
                <th>Status</th>
                <th>Received By</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td>DEL-0105</td>
                <td>Alpha Fabrics</td>
                <td>2025-05-12</td>
                <td>50m Cotton Fabric</td>
                <td>ORD-0012</td>
                <td>Complete</td>
                <td>Junessa Mae</td>
                <td>Confirm | Report Issue</td>
            </tr>
        </table>
    </div>
</body>
</html>
