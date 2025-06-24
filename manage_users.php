<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Delete user
if (isset($_GET['delete_user'])) {
    $id = (int)$_GET['delete_user'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

$result = $conn->query("SELECT id, name, email, user_type FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>Manage Users</h2>


    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr></thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['user_type'] ?></td>
                    <td>
                        <a href="?delete_user=<?= $user['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="admin_panel.php" class="btn btn-secondary">Back to Admin Panel</a>
</body>
</html>