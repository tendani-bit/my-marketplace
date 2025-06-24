<?php
session_start();
require_once 'database.php';

$user = $_SESSION['user'] ?? null;

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle product added to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];

    // Check if product already in cart
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += 1;
    } else {
        // Get product details from DB
        $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            $_SESSION['cart'][$productId] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }

        $stmt->close();
    }

    // Redirect to avoid resubmission
    header("Location: cart.php");
    exit();
}

// Handle removal
if (isset($_GET['remove'])) {
    $removeId = (int)$_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body class="container mt-5">
    <h2>Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Price (each)</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <?php $subtotal = $item['price'] * $item['quantity']; ?>
                    <?php $total += $subtotal; ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>R<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>R<?= number_format($subtotal, 2) ?></td>
                        <td><a href="cart.php?remove=<?= $id ?>" class="btn btn-sm btn-danger">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total: R<?= number_format($total, 2) ?></h4>
        <a href="checkout.php" class="btn btn-success">Checkout</a>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3">Continue Shopping</a>
</body>
</html>