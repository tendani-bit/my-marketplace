<?php
session_start();

// Only allow admins
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body class="container pt-5">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?></h1>
    <ul class="list-group">
        <li class="list-group-item"><a href="manage_users.php">Manage Users</a></li>
        <li class="list-group-item"><a href="manage_products.php">Manage Products</a></li>
        <li class="list-group-item"><a href="view_orders.php">View Orders</a></li>
    </ul>
    <a href="logout.php" class="btn btn-secondary mt-3">Logout</a>
</body>
</html>