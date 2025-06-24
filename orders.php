<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'buyer') {
    header("Location: login.php");
    exit();
}

require_once 'database.php';

$buyer_id = $_SESSION['user']['id'];

// Fetch orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE buyer_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $buyer_id);
$stmt->execute();
$orders_result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>My Orders</h2>

    <?php if ($orders_result->num_rows > 0): ?>
        <?php while ($order = $orders_result->fetch_assoc()): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Order #<?= $order['id'] ?></strong> — <?= $order['order_date'] ?><br>
                    <span>Total: $<?= number_format($order['total_price'], 2) ?></span>
                </div>
                <div class="card-body p-2">
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Product</th><th>Qty</th><th>Price</th></tr>
                        </thead>
                        <tbody>
                        <?php
                        $stmt = $conn->prepare("
                            SELECT oi.quantity, oi.price, p.name 
                            FROM order_items oi 
                            JOIN products p ON oi.product_id = p.id 
                            WHERE oi.order_id = ?
                        ");
                        $stmt->bind_param("i", $order['id']);
                        $stmt->execute();
                        $items_result = $stmt->get_result();

                        while ($item = $items_result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>$<?= number_format($item['price'], 2) ?></td>
                            </tr>
                        <?php endwhile;
                        $stmt->close();
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">You have no past orders.</div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary">Back to Shop</a>
</body>
</html>

<?php $conn->close(); ?>
