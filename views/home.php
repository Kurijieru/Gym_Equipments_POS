<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym POS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <style>
/* Formal Gym Theme */
body {
    background-color: #f4f4f9;
    font-family: 'Arial', sans-serif;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #2c3e50;
    position: fixed;
    padding-top: 20px;
    color: white;
    left: 0;
    top: 0;
    border-right: 4px solid #3498db;
    box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
}

.sidebar a {
    padding: 15px;
    display: block;
    color: white;
    text-decoration: none;
    font-size: 18px;
    font-weight: bold;
    transition: 0.3s;
}

.sidebar a:hover {
    background-color: #2980b9;
    color: white;
    transform: scale(1.05);
}

.main-content {
    text-align: center;
    background: #ecf0f1;
    padding: 50px;
    width: 70%;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    margin-left: 270px;
    color: #333;
    border: 2px solid #3498db;
}

.order-button {
    font-size: 24px;
    padding: 15px 30px;
    background-color: #3498db;
    color: white;
    border: none;
    font-weight: bold;
    transition: 0.3s;
}

.order-button:hover {
    background-color: #2980b9;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.card {
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.2s ease-in-out;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    background: #ecf0f1;
    text-align: center;
    color: #333;
    padding: 10px;
    border: 2px solid #3498db;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
}

.card img {
    height: 130px;
    object-fit: cover;
    width: 100%;
}

.order-summary {
    position: fixed;
    right: 0;
    top: 0;
    width: 320px;
    height: 100vh;
    background-color: #34495e;
    padding: 20px;
    box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    border-left: 4px solid #3498db;
}

.btn-success {
    background-color: #27ae60;
    border: none;
    font-weight: bold;
    color: white;
    transition: 0.3s;
}

.btn-success:hover {
    background-color: #2ecc71;
}

.btn-secondary {
    background-color: #7f8c8d;
    border-color: #7f8c8d;
    color: white;
    transition: 0.3s;
}

.btn-secondary:hover {
    background-color: #95a5a6;
}

</style>

</head>
<body>
    <div class="sidebar">
        <a href="home.php"><i class="fas fa-home"></i> Home</a>
        <a href="../actions/logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="main-content">
        <h1>Welcome</h1>
        <p>Ready to place an order?</p>
        <a href="cashier.php" class="btn btn-primary order-button">Make an Order</a>
    </div>
</body>
</html>
