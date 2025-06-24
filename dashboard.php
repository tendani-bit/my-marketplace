<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'seller') {
    header("Location: login.php");
    exit();
}

require_once 'database.php';

$seller_id = $_SESSION['user']['id'];

// Delete Product
if (isset($_GET['delete'])) {
    $product_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
    $stmt->bind_param("ii", $product_id, $seller_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch Products
$stmt = $conn->prepare("SELECT id, name, price FROM products WHERE seller_id = ?");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?> (Seller)</h2>

    <a href="add_products.php" class="btn btn-primary mb-3">Add New Product</a>

    <h4>Your Products</h4>
    <table class="table table-bordered">
        <thead>
            <tr><th>Name</th><th>Price</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>R<?= number_format($row['price'], 2) ?></td>
                    <td>
                        <a href="edit_products.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="logout.php" class="btn btn-secondary">Logout</a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>