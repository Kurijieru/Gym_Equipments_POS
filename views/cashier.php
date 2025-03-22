<?php
session_start();

if (empty($_SESSION)) {
    header("location: ../views/");
    exit;
}

include "../classes/Product.php";

$product = new Product();

$product_list = $product->displayProducts();

$categories = $product->getCategories();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    $orders = $_POST['orders'];
    foreach ($orders as $product_id => $quantity) {
        if ($quantity > 0) {
            $total_price = $product->getProductPrice($product_id) * $quantity;
            $product->adjustStock($product_id, $quantity);

            $conn = $product->getConnection(); 

            $query = "INSERT INTO sales (product_id, quantity, total_price) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            
            $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $quantity, PDO::PARAM_INT);
            $stmt->bindValue(3, $total_price, PDO::PARAM_STR);
            
            $stmt->execute();
        }
    }
    $_SESSION['orders'] = $_POST['orders'];
    header("location: order-summary.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>
<style>

body {
    background-color: #f4f4f9; 
    font-family: 'Arial', sans-serif; 
    color: #333; 
}

.container {
    max-width: 1200px;
    margin: auto;
    padding-top: 20px;
}

.sidebar {
    width: 250px;
    height: 100vh;
    background: linear-gradient(145deg, #34495e, #2c3e50); 
    position: fixed;
    padding-top: 20px;
    color: white;
    border-right: 4px solid #2980b9; 
    box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1); 
}

.sidebar a {
    padding: 15px;
    display: block;
    color: white;
    text-decoration: none;
    font-size: 20px;
    font-weight: bold;
    transition: 0.3s ease-in-out;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar a:hover {
    background: #2980b9; 
    color: white;
    transform: scale(1.05);
}

.main-content {
    margin-left: 270px;
    padding: 20px;
    background-color: #ecf0f1; 
    color: #333;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); 
}

#TITLE {
    margin-left: -250px;
    font-size: 32px;
    font-weight: bold;
    text-transform: uppercase;
    text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3); 
    color: #2980b9; 
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    width: 70%;
    gap: 15px;
}

.card {
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.2s ease-in-out;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    background: linear-gradient(135deg, #ecf0f1, #dfe6e9); 
    text-align: center;
    color: #333; 
    font-weight: bold;
    padding: 15px;
    border: 2px solid #2980b9; 
}

.card:hover {
    transform: scale(1.05); 
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
    border-color: #3498db; 
}

.card img {
    height: 250px;
    object-fit: cover;
    width: 100%;
}

.order-summary {
    position: fixed;
    right: 0;
    top: 0;
    width: 320px;
    height: 100vh;
    background-color: #95a5a6; 
    padding: 20px;
    box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
}

.quantity-controls {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}

.quantity-controls input {
    width: 50px;
    text-align: center;
}

#categoryFilter {
    width: 70%;
    padding: 10px;
    font-size: 16px;
    background-color: #ecf0f1;
    border: 2px solid #2980b9; 
    border-radius: 5px;
    color: #333;
}

</style>

<body>
    <div class="sidebar">
        <a href="home.php"><i class="fas fa-home"></i> Home</a>
        <a href="../actions/logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="main-content">
        <h1 class="text-center" id="TITLE">GYM EQUIPMENTS & SUPPLEMENTS</h1>
        <h2 class="text-center" id="TITLE">Select Your Products</h2>

        <div class="mb-3">
            <label for="categoryFilter">Filter by Category:</label>
            <select id="categoryFilter" class="form-control" onchange="filterCategory()">
                <option value="all">All Categories</option>
                <?php foreach ($categories as $category) { ?>
                    <option value="<?= htmlspecialchars($category['category']) ?>">
                        <?= htmlspecialchars($category['category']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        
        <form id="orderForm" action="" method="post">
            <div class="product-grid">
                <?php foreach ($product_list as $product) { ?>
                    <div class="card product-card" data-category="<?= htmlspecialchars($product['category']) ?>">
                        <img src="<?= htmlspecialchars($product['image']) ? htmlspecialchars($product['image']) : '../images/default-product.jpg' ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"> <?= htmlspecialchars($product['product_name']) ?> </h5>
                            <p class="fw-bold">₱<?= htmlspecialchars($product['price']) ?></p>
                            <div class="quantity-controls">
                                <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity('<?= $product['product_id'] ?>', -1)">-</button>
                                <input type="number" id="quantity-<?= $product['product_id'] ?>" name="orders[<?= $product['product_id'] ?>]" value="0" min="0" max="<?= $product['quantity'] ?>" class="form-control" data-name="<?= htmlspecialchars($product['product_name']) ?>" data-price="<?= htmlspecialchars($product['price']) ?>">
                                <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity('<?= $product['product_id'] ?>', 1)">+</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
        <div class="order-summary">
            <h4>Order Summary</h4>
            <ul id="order-list" class="list-group"></ul>
            <h5 class="mt-3">Total: ₱<span id="total-price">0</span></h5>
            <div class="text-center">
                <button type="submit" class="btn btn-success mt-4" name="confirm_order" onclick="return validateOrder()">Confirm Order</button>
            </div>
        </div>
    </form>
    
    <script>
        function changeQuantity(productId, change) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            let currentQuantity = parseInt(quantityInput.value) || 0;
            const maxQuantity = parseInt(quantityInput.max);
            currentQuantity = Math.max(0, Math.min(maxQuantity, currentQuantity + change));
            quantityInput.value = currentQuantity;
            updateOrderSummary();
        }
        
        function updateOrderSummary() {
            const orderList = document.getElementById("order-list");
            const totalPriceElement = document.getElementById("total-price");
            orderList.innerHTML = "";
            let totalPrice = 0;
            document.querySelectorAll('input[type=number]').forEach(input => {
                let quantity = parseInt(input.value) || 0;
                if (quantity > 0) {
                    let name = input.dataset.name;
                    let price = parseFloat(input.dataset.price) * quantity;
                    totalPrice += price;
                    orderList.innerHTML += `<li class='list-group-item'>${name} x${quantity} - ₱${price.toFixed(2)}</li>`;
                }
            });
            totalPriceElement.innerText = totalPrice.toFixed(2);
        }

        function filterCategory() {
            let selectedCategory = document.getElementById("categoryFilter").value;
            let products = document.querySelectorAll(".product-card");
            products.forEach(product => {
                product.style.display = (selectedCategory === "all" || product.dataset.category === selectedCategory) ? "block" : "none";
            });
        }
        
        function validateOrder() {
            return document.getElementById("order-list").innerHTML.trim() !== "" || (alert("Please add at least one product."), false);
        }
    </script>
</body>
</html>
