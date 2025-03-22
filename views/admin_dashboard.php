<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        background-color: #f4f4f9;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .navbar {
        background-color: #2c3e50;
        padding: 20px;
        border-bottom: 3px solid #3498db;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar a {
        color: white;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        padding: 10px 20px;
        transition: 0.3s;
    }

    .navbar a:hover {
        color: #3498db;
    }

    .card {
        cursor: pointer;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        background: #ecf0f1;
        color: #34495e;
        text-align: center;
        padding: 20px;
        border: 2px solid #3498db;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        border-color: #2980b9;
    }

    .status-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
        box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.1);
    }

    .active {
        background-color: #27ae60;
    }

    .inactive {
        background-color: #7f8c8d;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        border: none;
        border-radius: 5px;
        transition: 0.3s ease-in-out;
        cursor: pointer;
    }

    .btn-success {
        background-color: #27ae60;
        color: white;
    }

    .btn-success:hover {
        background-color: #2ecc71;
    }

    .btn-cancel {
        background-color: #bdc3c7;
        color: #2c3e50;
    }

    .btn-cancel:hover {
        background-color: #95a5a6;
    }

    .table, th {
        color: #34495e;
    }

    th {
        background-color: #ecf0f1;
        padding: 12px;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>

</head>
<body>
<?php 
session_start(); 
include "../classes/Product.php";
include_once "Sales.php";

$product = new Product();
$sales = new Sales();
$product_list = $product->displayProducts();
$sales_data = $sales->getSalesReport();

if (!isset($_SESSION['login_time'])) {
    $_SESSION['login_time'] = date("Y-m-d H:i:s");
}
if (!isset($_SESSION['logout_time'])) {
    $_SESSION['logout_time'] = "Still Active";
}
$isActive = ($_SESSION['logout_time'] === "Still Active");
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a href="#" class="navbar-brand"></a>
        <span class="navbar-text ms-3" style="font-size:30px">Welcome, <?= isset($_SESSION['username']) ? ucfirst($_SESSION['username']) : 'Guest' ?></span>
        <a href="../actions/logout.php" class="btn btn-danger ms-3" onclick="setLogoutTime()">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card p-3 bg-info text-white" onclick="showSection('salesReport')">
                <h5>Sales Report</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-success text-white" onclick="showSection('productList')">
                <h5>Product List</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-warning text-dark" onclick="showSection('userInfo')">
                <h5>User Info</h5>
            </div>
        </div>
    </div>
    
    <div id="salesReport" class="mt-4 d-none">
    <h3>Sales Report</h3>
    <canvas id="salesChart"></canvas>
</div>

<script>
    const salesData = <?= json_encode($sales_data) ?>;
    const labels = salesData.map(sale => sale.sale_date);
    const data = salesData.map(sale => parseFloat(sale.total_sales));

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Sales (₱)',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
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

<div id="productList" class="mt-4">
    <h3>Product List</h3>
    <button class="btn btn-primary mb-3" onclick="window.location.href='add-product.php'">Add Product</button>
    
    <div class="mb-3">
        <label for="categoryFilter">Filter by Category:</label>
        <select id="categoryFilter" class="form-control" onchange="filterCategory()">
            <option value="all">All Categories</option>
            <?php 
            $categories = $product->getCategories();
            foreach ($categories as $category) { 
                echo '<option value="'.htmlspecialchars($category['category']).'">'.htmlspecialchars($category['category']).'</option>'; 
            }
            ?>
        </select>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            <?php foreach ($product_list as $product) { ?>
                <tr data-category="<?= htmlspecialchars($product['category']) ?>">
                    <td><?= htmlspecialchars($product['product_id']) ?></td>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td>₱<?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td>
                        <a href="edit-product1.php?id=<?= $product['product_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete-product.php?id=<?= $product['product_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    function filterCategory() {
        let selectedCategory = document.getElementById("categoryFilter").value;
        let rows = document.querySelectorAll("#productTableBody tr");
        
        rows.forEach(row => {
            let rowCategory = row.getAttribute("data-category");
            if (selectedCategory === "all" || rowCategory === selectedCategory) {
                row.style.display = "table-row";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>

<div id="userInfo" class="mt-4 d-none">
    <h3>User Info</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Status</th>
                <th>Username</th>
                <th>Login Time</th>
                <th>Logout Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="status-indicator <?= $isActive ? 'active' : 'inactive' ?>"></span></td>
                <td><?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown' ?></td>
                <td><?= $_SESSION['login_time'] ?></td>
                <td><?= $_SESSION['logout_time'] ?></td>
            </tr>
        </tbody>
    </table>
</div>
</div>

<script>
    function showSection(sectionId) {
        document.getElementById('salesReport').classList.add('d-none');
        document.getElementById('productList').classList.add('d-none');
        document.getElementById('userInfo').classList.add('d-none');
        document.getElementById(sectionId).classList.remove('d-none');
    }
    
    function setLogoutTime() {
        <?php $_SESSION['logout_time'] = date("Y-m-d H:i:s"); ?>
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
