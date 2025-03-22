<?php 
session_start();
include "../classes/Product.php";

// Create an instance of the Product class
$product = new Product;

// Initialize order details
$order_details = [];
$total_price = 0; // Ensure the variable is always set

// Retrieve the order details from the session
if (isset($_SESSION['orders']) && !empty($_SESSION['orders'])) {
    foreach ($_SESSION['orders'] as $product_id => $quantity) {
        if ($quantity > 0) {
            $product_info = $product->displaySpecificProduct($product_id);
            if ($product_info) {
                $product_info['quantity'] = $quantity;
                $product_info['total_price'] = $quantity * $product_info['price'];
                $order_details[] = $product_info;
                $total_price += $product_info['total_price'];
            }
        }
    }
}

// Handle payment confirmation
if (isset($_POST['confirm_payment'])) {
    $_SESSION['order_details'] = $order_details;
    $_SESSION['total_price'] = $total_price;
    $_SESSION['payment_method'] = 'cash'; // Default payment method
    unset($_SESSION['orders']); // Clear session orders after confirmation
    header("Location: sales_receipt.php");
    exit;
}

// Handle back to menu actions
if (isset($_POST['back_to_menu'])) {
    header("Location: cashier.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
/* Body Styling */
body {
    background-color: #ecf0f1; /* Lighter background for a formal gym look */
    color: #333; /* Dark text for readability */
    font-family: 'Arial', sans-serif;
}

/* Order Card */
.order-card {
    background: #34495e; /* Deep grayish-blue background for a formal gym vibe */
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1); /* Soft shadow for a sleek look */
    margin-top: 50px;
    color: #ffffff;
    border: 2px solid #2980b9; /* Soft blue border */
}

/* Total Price */
.total-price {
    font-size: 1.8rem;
    font-weight: bold;
    text-align: right;
    color: #2980b9; /* Soft blue for the total price */
    margin-top: 10px;
}

/* Payment Box */
.payment-box {
    background: #7f8c8d; /* Cool gray for a subtle professional look */
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
    color: #ffffff;
    border: 2px solid #2980b9; /* Soft blue border */
}

/* Primary Button - Blue for Power */
.btn-primary {
    background-color: #2980b9; /* Soft blue for power */
    border-color: #2980b9;
    transition: 0.3s;
    font-weight: bold;
}

.btn-primary:hover {
    background-color: #2471a3; /* Darker blue on hover */
    border-color: #2471a3;
}

/* Secondary Button */
.btn-secondary {
    background-color: #2c3e50; /* Formal dark blue-gray */
    border-color: #2c3e50;
    color: #fff;
    transition: 0.3s;
}

.btn-secondary:hover {
    background-color: #34495e; /* Darker blue-gray on hover */
    border-color: #34495e;
}
</style>

</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="order-card col-md-8">
            <h2 class="text-center mb-4">Review Your Order</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($order_details)) { ?>
                            <?php foreach ($order_details as $item) { ?>
                                <tr>
                                    <td style="color: white;"><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td style="color: white;"><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td style="color: white;">₱<?= number_format($item['price'], 2) ?></td>
                                    <td style="color: white;">₱<?= number_format($item['total_price'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4" class="text-center text-danger">No orders found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="total-price">Total: ₱<?= number_format($total_price, 2) ?></div>
            
            <div class="payment-box text-center">
                <h4>Payment Method</h4>
                <h3 class="text-success">Cash</h3>
                <form method="post">
                    <input type="hidden" name="payment_method" value="cash">
                    <button class="btn btn-primary mt-3 px-4" name="confirm_payment" type="submit">Proceed to Payment</button>
                    <button class="btn btn-secondary mt-3 px-4" name="back_to_menu" type="submit">Cancel/Go Back</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
