<?php
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }

    
    $completedOrders = 25;
    $pendingOrders = 8;
    $cancelledOrders = 2;

    $topSelling = [
        ['name' => 'White T-Shirt', 'sold' => 120],
        ['name' => 'Denim Jacket', 'sold' => 95],
        ['name' => 'Black Jeans', 'sold' => 80],
    ];

    $inventoryValue = 23500; 
    $lowStockItems = 4;
    $outOfStockItems = 2;
    $totalItems = 60;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StockHub Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        }
        .search-bar {
            padding: 8px;
            border-radius: 5px;
            border: none;
            width: 200px;
        }
        .dashboard-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            font-size: 16px;
        }
        .card h3 {
            margin-bottom: 15px;
            font-size: 20px;
        }
        .card ul {
            list-style: none;
            padding-left: 0;
        }
        .card ul li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <img src="logo.png" alt="Logo" class="logo">
        </div>
        <ul class="menu">
            <li><a href="#">🏠 Home</a></li>
            <li><a href="inventory.php">📦 Inventory</a></li>
            <li><a href="sales.php">📈 Sales</a></li>
            <li><a href="suppliers.php">🚚 Suppliers</a></li>
        </ul>
        <a href="logout.php" class="logout">🚪 Logout</a>
    </div>

    <div class="content">
        <div class="topbar">
            <h2>StockHub</h2>
            <input type="text" class="search-bar" placeholder="Search...">
        </div>

        <div class="dashboard-content">
         
            <div class="card">
                <h3>📊 Order Status</h3>
                <canvas id="orderChart" width="100" height="100"></canvas>
            </div>

            <div class="card">
                <h3>📈 Top Selling Products</h3>
                <canvas id="topProductsChart" width="100" height="100"></canvas>
            </div>

            <div class="card">
                <h3>💰 Total Inventory Value</h3>
                <p><strong>₱<?= number_format($inventoryValue, 2) ?></strong></p>
                <p>Total Items: <?= $totalItems ?></p>
            </div>

            <div class="card">
                <h3>📦 Stock Levels</h3>
                <ul>
                    <li>⚠️ Low Stock Items: <?= $lowStockItems ?></li>
                    <li>❌ Out of Stock Items: <?= $outOfStockItems ?></li>
                    <li>📦 Total Items: <?= $totalItems ?></li>
                </ul>
            </div>
        </div>
    </div>

    <script>

        const orderChart = document.getElementById('orderChart').getContext('2d');
        new Chart(orderChart, {
            type: 'pie',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [
                        <?= $completedOrders ?>,
                        <?= $pendingOrders ?>,
                        <?= $cancelledOrders ?>
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const topProductsChart = document.getElementById('topProductsChart').getContext('2d');
        new Chart(topProductsChart, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($topSelling, 'name')) ?>,
                datasets: [{
                    label: 'Units Sold',
                    data: <?= json_encode(array_column($topSelling, 'sold')) ?>,
                    backgroundColor: '#8B6F3F'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
