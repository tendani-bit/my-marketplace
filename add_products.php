<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'seller') {
    header("Location: login.php");
    exit();
}

require_once 'database.php';

$seller_id = $_SESSION['user']['id'];
$message = '';

// Handle product submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $image_name = '';

    if ($name && $price > 0 && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'images/';
        $original_name = basename($_FILES['image']['name']);
        $safe_name = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $original_name);
        $target_path = $upload_dir . $safe_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_name = $safe_name;

            $stmt = $conn->prepare("INSERT INTO products (name, price, image, seller_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdsi", $name, $price, $image_name, $seller_id);

            if ($stmt->execute()) {
                $message = "Product added successfully!";
            } else {
                $message = "Error: Could not add product.";
            }

            $stmt->close();
        } else {
            $message = "Image upload failed.";
        }
    } else {
        $message = "Please fill in all fields and upload a valid image.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>Add Product</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control" required autofocus>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>
    <div class="form-group">
        <label>Price (in ZAR)</label>
        <input type="number" name="price" class="form-control" step="0.01" min="0.01" required>
    </div>
    <div class="form-group">
        <label>Product Image</label>
        <input type="file" name="image" class="form-control-file" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success">Add Product</button>
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</form>
</body>
</html>
