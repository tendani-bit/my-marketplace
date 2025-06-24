<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Delete order (items first, then order)
if (isset($_GET['delete_order'])) {
    $id = (int)$_GET['delete_order'];
    $conn->query("DELETE FROM order_items WHERE order_id = $id");
    $conn->query("DELETE FROM orders WHERE id = $id");
    header("Location: view_order.php");
    exit();
}

$query = "
SELECT o.id AS order_id, o.total_price, o.order_date, u.name AS buyer_name 
FROM orders o
JOIN users u ON o.buyer_id = u.id
ORDER BY o.order_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>All Orders</h2>
    <table class="table table-bordered">
        <thead><tr><th>Order ID</th><th>Buyer</th><th>Total</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
            <?php while ($order = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $order['order_id'] ?></td>
                    <td><?= htmlspecialchars($order['buyer_name']) ?></td>
                    <td>R<?= number_format($order['total_price'], 2) ?></td>
                    <td><?= $order['order_date'] ?></td>
                    <td>
                        <a href="?delete_order=<?= $order['order_id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="admin_panel.php" class="btn btn-secondary">Back to Admin Panel</a>
</body>
</html>