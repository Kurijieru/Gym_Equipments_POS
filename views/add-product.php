<?php
require_once "../classes/Product.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product = new Product();
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = basename($_FILES['image']['name']);
        $image_path = "../uploads/" . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image_url = $image_path;
        } else {
            $image_url = "default.jpg";
        }
    } else {
        $image_url = "default.jpg";
    }

    $product->addProduct($product_name, $price, $quantity, $category, $image_url);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        background-color: #f4f4f9;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .container {
        max-width: 600px;
        margin: auto;
        padding-top: 50px;
    }

    h3 {
        text-align: center;
        font-size: 2.5rem;
        color: #3498db;
        text-transform: uppercase;
        font-weight: bold;
        text-shadow: 3px 3px 10px rgba(52, 152, 219, 0.8);
    }

    .form-control {
        margin-bottom: 15px;
        padding: 12px;
        background-color: #ecf0f1;
        color: #333;
        border: 2px solid #3498db;
        border-radius: 5px;
    }

    label {
        font-size: 1.1rem;
        color: #333;
    }

    .btn-success {
        background-color: #27ae60;
        color: white;
        font-size: 1.2rem;
        padding: 12px 25px;
        text-transform: uppercase;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        transition: 0.3s;
    }

    .btn-success:hover {
        background-color: #2ecc71;
    }

    .btn-secondary {
        background-color: #bdc3c7;
        color: white;
        font-size: 1.1rem;
        padding: 12px 25px;
        text-transform: uppercase;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        transition: 0.3s;
    }

    .btn-secondary:hover {
        background-color: #95a5a6;
    }

    input[type="file"] {
        background-color: #ecf0f1;
        border: 2px solid #3498db;
        color: #333;
        padding: 8px;
        font-size: 1rem;
        border-radius: 5px;
    }

    form {
        background-color: #ecf0f1;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
</style>

<body>
<div class="container mt-5">
    <h3>Add Product</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" class="form-control" name="product_name" required>
        </div>
        <div class="mb-3">
            <label>Price:</label>
            <input type="number" class="form-control" name="price" required>
        </div>
        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" class="form-control" name="quantity" required>
        </div>
        <div class="mb-3">
            <label>Category:</label>
            <input type="text" class="form-control" name="category" required>
        </div>
        <div class="mb-3">
            <label>Product Image:</label>
            <input type="file" class="form-control" name="image">
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
