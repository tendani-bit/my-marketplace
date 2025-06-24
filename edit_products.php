<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'seller') {
    header("Location: login.php");
    exit();
}

require_once 'database.php';

$seller_id = $_SESSION['user']['id'];
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Product not found or access denied.");
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $image_name = $product['image']; // default to current image

    if ($name && $price > 0 && $description) {
        // If new image uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'images/';
            $original_name = basename($_FILES['image']['name']);
            $safe_name = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $original_name);
            $target_path = $upload_dir . $safe_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_name = $safe_name;
            } else {
                $message = "Image upload failed. Product not updated.";
            }
        }

        if (!$message) {
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ? AND seller_id = ?");
            $stmt->bind_param("ssdssi", $name, $description, $price, $image_name, $product_id, $seller_id);

            if ($stmt->execute()) {
                $message = "Product updated successfully!";
                $product['name'] = $name;
                $product['description'] = $description;
                $product['price'] = $price;
                $product['image'] = $image_name;
            } else {
                $message = "Error updating product.";
            }

            $stmt->close();
        }
    } else {
        $message = "Please fill in all fields correctly.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>Edit Product</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Price (ZAR)</label>
            <input type="number" name="price" class="form-control" step="0.01" min="0.01" required value="<?= htmlspecialchars($product['price']) ?>">
        </div>
        <div class="form-group">
            <label>Product Image (optional)</label><br>
            <?php if (!empty($product['image'])): ?>
                <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="Current Image" style="max-height: 150px;"><br>
            <?php endif; ?>
            <input type="file" name="image" class="form-control-file" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</body>
</html>