<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Archive-orders.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Archived Orders</title>
</head>
<body>
    <h1>Archived Orders</h1>
    <p>This is where you can view archived orders.</p>
    <a href="admin_dashboard.php">Back to Dashboard</a>
    <a href="../actions/Logout.php">Logout</a>
</body>
</html>