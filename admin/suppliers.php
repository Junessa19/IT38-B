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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
        .logout { margin-top: 30px; font-weight: bold; display: inline-block; }
        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            background: #C7A061;
            min-height: 100vh;
            padding: 20px;
            overflow-y: auto;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #8B6F3F;
            padding: 15px;
            color: white;
            border-radius: 5px;
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
            background: white;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #8B6F3F;
            color: white;
        }
        tr:hover {
            background-color: #f1e2ca;
        }
        a.supplier-link {
            color: #4b3d23;
            text-decoration: underline;
            font-weight: bold;
        }
        #product-list {
            display: none;
            background: white;
            padding: 15px;
            border-radius: 8px;
        }
        #product-list h4 {
            margin-bottom: 15px;
        }
        #products-table th, #products-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        #products-table th {
            background-color: #8B6F3F;
            color: white;
        }
        #products-table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        button.order-btn {
            background-color: #8B6F3F;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        button.order-btn:hover {
            background-color: #6c5731;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }
        .modal input {
            width: 80%;
            padding: 8px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .modal button {
            margin-top: 10px;
            padding: 8px 12px;
            border: none;
            background: #8B6F3F;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal button:hover {
            background: #6c5731;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <img src="logo.png" alt="Logo" class="logo" />
        </div>
        <ul class="menu">
            <li><a href="dashboard.php">🏠 Home</a></li>
            <li><a href="inventory.php">📦 Inventory</a></li>
            <li><a href="sales.php">📈 Sales</a></li>
            <li><a href="suppliers.php">🚚 Suppliers</a></li>
        </ul>
        <a href="logout.php" class="logout">🚪 Logout</a>
    </div>

    <div class="content">
        <div class="topbar">
            <h2>🚚 Suppliers</h2>
            <input type="text" class="search-bar" placeholder="Search..." />
        </div>

        <h3>📋 Supplier List</h3>
        <table>
            <tr>
                <th>Supplier Name</th>
                <th>Contact</th>
                <th>Location</th>
                <th>Supplies</th>
                <th>Status</th>
            </tr>
            <tr><td><a href="#" class="supplier-link" data-supplier="alpha">Alpha Fabrics</a></td><td>Jane Reyes</td><td>Pasig</td><td>Textiles, Buttons</td><td>Active</td></tr>
            <tr><td><a href="#" class="supplier-link" data-supplier="bravo">Bravo Threads</a></td><td>Mark Santos</td><td>QC</td><td>Zippers, Labels</td><td>Active</td></tr>
            <tr><td><a href="#" class="supplier-link" data-supplier="charlie">Charlie Textiles</a></td><td>Liza Tan</td><td>Makati</td><td>Denim, Threads</td><td>Inactive</td></tr>
            <tr><td><a href="#" class="supplier-link" data-supplier="delta">Delta Couture</a></td><td>Ana Cruz</td><td>Taguig</td><td>Wool, Coats</td><td>Active</td></tr>
            <tr><td><a href="#" class="supplier-link" data-supplier="echo">Echo Apparel</a></td><td>John Lim</td><td>Manila</td><td>Shirts, Pants</td><td>Active</td></tr>
        </table>

        <div id="product-list">
            <h4>🧾 Products Supplied</h4>
            <table id="products-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Order</th>
                    </tr>
                </thead>
                <tbody id="products"></tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="orderModal">
        <div class="modal-content">
            <h4 id="modalTitle"></h4>
            <input type="number" id="orderQty" placeholder="Enter quantity" min="1" />
            <button id="confirmOrder">Place Order</button>
            <button onclick="closeModal()">Cancel</button>
        </div>
    </div>

    <script>
        const supplierProducts = {
            alpha: [
                { name: "Cotton Shirt", image: "images/cotton-shirt.jpg", quantity: 150, price: 350 },
                { name: "Buttons Pack", image: "images/buttons-pack.jpg", quantity: 300, price: 120 },
                { name: "Linen Fabric", image: "images/linen-fabric.jpg", quantity: 100, price: 480 },
                { name: "Elastic Bands", image: "images/elastic-bands.jpg", quantity: 200, price: 90 },
                { name: "Velcro Strips", image: "images/velcro.jpg", quantity: 180, price: 110 }
            ],
            bravo: [
                { name: "Zipper Set", image: "images/zipper-set.jpg", quantity: 200, price: 250 },
                { name: "Label Roll", image: "images/label-roll.jpg", quantity: 150, price: 180 },
                { name: "Thread Cone", image: "images/thread-cone.jpg", quantity: 250, price: 140 },
                { name: "Tag Gun", image: "images/tag-gun.jpg", quantity: 50, price: 500 },
                { name: "Label Stickers", image: "images/label-stickers.jpg", quantity: 300, price: 100 }
            ],
            charlie: [
                { name: "Denim Roll", image: "images/denim-roll.jpg", quantity: 80, price: 900 },
                { name: "Thread Spool", image: "images/thread-spool.jpg", quantity: 400, price: 150 },
                { name: "Sewing Needles", image: "images/needles.jpg", quantity: 500, price: 70 },
                { name: "Pattern Paper", image: "images/pattern-paper.jpg", quantity: 120, price: 180 },
                { name: "Denim Patches", image: "images/denim-patch.jpg", quantity: 90, price: 220 }
            ],
            delta: [
                { name: "Wool Coat", image: "images/wool-coat.jpg", quantity: 60, price: 1600 },
                { name: "Wool Bundle", image: "images/wool-bundle.jpg", quantity: 90, price: 750 },
                { name: "Fleece Fabric", image: "images/fleece.jpg", quantity: 70, price: 690 },
                { name: "Overcoat Buttons", image: "images/coat-buttons.jpg", quantity: 300, price: 140 },
                { name: "Coat Hanger", image: "images/coat-hanger.jpg", quantity: 110, price: 85 }
            ],
            echo: [
                { name: "Casual Shirt", image: "images/casual-shirt.jpg", quantity: 180, price: 400 },
                { name: "Chino Pants", image: "images/chino-pants.jpg", quantity: 120, price: 600 },
                { name: "Blazers", image: "images/blazer.jpg", quantity: 70, price: 850 },
                { name: "Polo Shirts", image: "images/polo-shirt.jpg", quantity: 150, price: 420 },
                { name: "Cargo Shorts", image: "images/cargo-shorts.jpg", quantity: 130, price: 390 }
            ]
        };

        const productListDiv = document.getElementById('product-list');
        const productsTableBody = document.getElementById('products');
        const supplierLinks = document.querySelectorAll('.supplier-link');
        const orderModal = document.getElementById('orderModal');
        const modalTitle = document.getElementById('modalTitle');
        const orderQty = document.getElementById('orderQty');
        const confirmOrder = document.getElementById('confirmOrder');

        let currentProduct = '';
        let currentSupplier = '';

        supplierLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const supplier = this.getAttribute('data-supplier');
                const products = supplierProducts[supplier];
                if (!products) return;
                productsTableBody.innerHTML = '';
                products.forEach(product => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><img src="${product.image}" alt="${product.name}"></td>
                        <td>${product.name}</td>
                        <td>${product.quantity}</td>
                        <td>₱${product.price.toFixed(2)}</td>
                        <td><button class="order-btn" data-supplier="${supplier}" data-product="${product.name}">Order</button></td>
                    `;
                    productsTableBody.appendChild(tr);
                });
                productListDiv.style.display = 'block';
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('order-btn')) {
                currentProduct = e.target.getAttribute('data-product');
                currentSupplier = e.target.getAttribute('data-supplier');
                modalTitle.textContent = `Order: ${currentProduct}`;
                orderQty.value = '';
                orderModal.style.display = 'flex';
            }
        });

        confirmOrder.addEventListener('click', () => {
            const qty = parseInt(orderQty.value);
            if (isNaN(qty) || qty <= 0) {
                alert('Please enter a valid quantity.');
                return;
            }
            alert(`Order placed for ${qty} pcs of "${currentProduct}" from ${currentSupplier}.`);
            closeModal();
        });

        function closeModal() {
            orderModal.style.display = 'none';
        }
    </script>
</body>
</html>
