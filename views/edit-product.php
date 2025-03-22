<?php
session_start();

// Redirect if user is not logged in or not an admin
if (empty($_SESSION) || $_SESSION['role'] !== 'admin') {
    header("location: ../views/index.php");  // Redirect to login or error page if needed
    exit;
}

require "../classes/Product.php";

$product = new Product();

// Validate that a product ID exists in the URL
if (!isset($_GET['product_id'])) {
    die("Invalid product ID");
}

// Fetch product details using the product ID from the URL
$product_id = $_GET['product_id'];
$product_details = $product->displaySpecificProduct($product_id);

// If no product details found, handle the error
if (!$product_details) {
    die("Product not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a href="manage-product.php" class="navbar-brand ms-3">
            <i class="fa-solid fa-house fa-2x text-dark"></i>
        </a>

        <div class="ms-auto me-3 navbar-nav">
            <a href="../actions/logout.php" class="nav-link" title="Logout">
                <i class="fa-solid fa-user-xmark fa-2x text-danger"></i>
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card border-0 mx-auto w-50">
            <div class="card-header bg-white border-0">
                <h1 class="display-4 fw-bold text-warning text-center">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Product
                </h1>
            </div>
            <div class="card-body">
                <form action="../actions/product-actions.php?product_id=<?= htmlspecialchars($product_id) ?>" method="post" class="w-75 mx-auto">
                    <div class="row mb-3">
                        <div class="col-md">
                            <label for="product-name" class="form-label small text-secondary">Product Name</label>
                            <input type="text" name="product_name" id="product-name" class="form-control" value="<?= htmlspecialchars($product_details['product_name']) ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label small text-secondary">Price</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="price-tag">$</span>
                                <input type="number" name="price" id="price" class="form-control" aria-label="Price" aria-describedby="price-tag" value="<?= htmlspecialchars($product_details['price']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label small text-secondary">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="<?= htmlspecialchars($product_details['quantity']) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <button type="submit" class="btn btn-warning w-100" name="edit_product">Edit</button>
                            <button href="manage-product.php" name="edit_product">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>