<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $desc = trim($_POST['description']);
    $image = trim($_POST['image']);

    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $desc, $image);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_products.php");
    exit();
}

// Delete product
if (isset($_GET['delete_product'])) {
    $id = (int)$_GET['delete_product'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_products.php");
    exit();
}

$result = $conn->query("SELECT id, name, price FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>Manage Products</h2>

    

    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr></thead>
        <tbody>
            <?php while ($product = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td>R<?= number_format($product['price'], 2) ?></td>
                    <td>
                        <a href="?delete_product=<?= $product['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="admin_panel.php" class="btn btn-secondary">Back to Admin Panel</a>
</body>
</html>