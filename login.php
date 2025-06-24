<?php
session_start();

// Database connection
require_once 'database.php';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name && $password) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        // Always run password_verify to prevent timing attacks
        $dummy_hash = '$2y$10$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG'; // fake bcrypt hash
        $verify = $user ? password_verify($password, $user['password']) : password_verify($password, $dummy_hash);

        if ($user && $verify) {
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            
            $stmt->close();
            $conn->close();

            switch ($user['user_type']) {
                case 'admin':
                    header("Location: admin_panel.php");
                    break;
                case 'seller':
                    header("Location: dashboard.php");
                    break;
                default:
                    header("Location: index.php");
            }
            exit();
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
    } else {
        $error = "Please enter both username and password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container pt-5">
    <h2>Login</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="post" novalidate>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="name" id="username" class="form-control" required autocomplete="username" autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-link">Register</a>
    </form>
</body>
</html>