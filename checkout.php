<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'buyer') {
    header("Location: login.php");
    exit();
}

$buyer_id = $_SESSION['user']['id'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit();
}

$total = 0.0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

$conn->begin_transaction();

try {
    // Create order
    $stmt = $conn->prepare("INSERT INTO orders (buyer_id, total_price, order_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("id", $buyer_id, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Add items to order
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart as $product_id => $item) {
        $stmt->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
        $stmt->execute();
    }
    $stmt->close();

    $conn->commit();
    $_SESSION['cart'] = [];
    $message = "Checkout successful! Your order ID is #{$order_id}.";

} catch (Exception $e) {
    $conn->rollback();
    $message = " Checkout failed: " . $e->getMessage();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>Checkout</h2>
    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <a href="index.php" class="btn btn-primary">Back to Shop</a>
    <a href="orders.php" class="btn btn-success">View My Orders</a>
</body>
</html>