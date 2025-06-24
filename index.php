<?php
session_start();
require_once 'database.php';

$user = $_SESSION['user'] ?? null;

$products = [];
$result = $conn->query("SELECT id, name, description, image, price FROM products");

if ($result && $result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Community Marketplace</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Marketplace</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

            <?php if (!$user): ?>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
            <?php else: ?>
                <?php if ($user['user_type'] === 'seller'): ?>
                    <li class="nav-item"><a class="nav-link" href="sellers_dashboard.php">Seller Dashboard</a></li>
                <?php elseif ($user['user_type'] === 'buyer'): ?>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                <?php elseif ($user['user_type'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="admin_panel.php">Admin Panel</a></li>
                <?php endif; ?>

                <li class="nav-item"><a class="nav-link" href="settings.php">Settings</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container">
    <h2 class="text-center mt-4">Welcome to Your Community Marketplace</h2>
    <p class="text-center">Helping local shops connect with nearby customers easily.</p>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="images/<?= urlencode($product['image'] ?? 'sample_product.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" />
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="card-text font-weight-bold">R<?= number_format($product['price'], 2) ?></p>
                        <form action="cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>" />
                            <button type="submit" class="btn btn-dark">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="bg-light text-center py-3 mt-4">
    <p>&copy; 2025 Community Marketplace</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>