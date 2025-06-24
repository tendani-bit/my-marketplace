<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'buyer') {
    header("Location: login.php");
    exit();
}

require_once 'database.php';
// Fetch all products with seller name
$sql = "SELECT products.*, users.username FROM products LEFT JOIN users ON products.seller_id = users.id";
$products = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Buyer Marketplace</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body class="container pt-5">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?> (Buyer)</h2>

    <h4>Available Products</h4>

    <?php if ($products && $products->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Seller</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td>$<?= number_format($product['price'], 2) ?></td>
                        <td><?= htmlspecialchars($product['username'] ?? 'Unknown') ?></td>
                        <td>
                            <form action="cart.php" method="post" class="m-0">
                                <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-primary">Add to Cart</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products available at the moment.</p>
    <?php endif; ?>

    <a href="logout.php" class="btn btn-secondary mt-3">Logout</a>
</body>
</html>