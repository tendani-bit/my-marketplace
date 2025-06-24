<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>Account Settings</h2>
    
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Your Information</h5>
            <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Role:</strong> <?= ucfirst($user['user_type']) ?></p>
           
        </div>
    </div>

    <?php if ($user['user_type'] === 'buyer'): ?>
        <div class="mb-3">
            <a href="orders.php" class="btn btn-outline-dark">View My Orders</a>
            <a href="cart.php" class="btn btn-outline-dark">Go to Cart</a>
        </div>
    <?php elseif ($user['user_type'] === 'seller'): ?>
        <div class="mb-3">
            <a href="seller_dashboard.php" class="btn btn-outline-dark">Manage My Products</a>
            <a href="earnings.php" class="btn btn-outline-dark">View Earnings</a>
        </div>
    <?php endif; ?>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Help & Support</h5>
            <a href="manual.php" class="btn btn-info">User Manual</a>
            <a href="mailto:support@marketplace.com" class="btn btn-warning">Email Support</a>
            <a href="https://wa.me/276315679" class="btn btn-success" target="_blank">WhatsApp Support</a>
        </div>
    </div>
</body>
</html>
