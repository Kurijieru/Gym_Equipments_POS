<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../views/"); // Redirect to login if not logged in
    exit;
}

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = '1cashier_db';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch all transactions
function getTransactions($conn) {
    $query = "SELECT * FROM orders"; // Adjust this query based on your database structure
    return $conn->query($query);
}

// Fetch transactions
$transactions = getTransactions($conn);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        .dropdown-menu {
            background-color: #2f8d2f; /* Dropdown background color */
        }
        .dropdown-item:hover {
            background-color: #0056b3; /* Dropdown item hover color */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a href="manage-product.php" class="navbar-brand">Your Daily Cravings</a>
        <span class="navbar-text ms-3">Welcome, <?= ucfirst($_SESSION['username']) ?></span>
        <div class="ms-auto">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    ☰
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="admin_dashboard.php">Dashboard</a></li>
                    <li><a class="dropdown-item" href="manage-product.php">Manage Products</a></li>
                    <li><a class="dropdown-item" href="manage-users.php">Manage Users</a></li>
                    <li><a class="dropdown-item" href="transaction_history.php">Transaction History</a></li>
                </ul>
            </div>
        </div>
        <a href="../actions/logout.php" class="btn btn-danger ms-3">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="display-6 fw-bold text-center">Transaction History</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Cashier</th>
                <th>Date</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($transaction = $transactions->fetch_assoc()) { ?>
                <tr>
                    <td><?= $transaction['id'] ?></td>
                    <td><?= $transaction['user_id'] ?></td> <!-- Adjust based on your user structure -->
                    <td><?= $transaction['created_at'] ?></td>
                    <td><?= $transaction['total'] ?></td> <!-- Adjust based on your total structure -->
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>