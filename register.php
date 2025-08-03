<?php
require_once 'config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Bắt đầu giao dịch để đảm bảo tính toàn vẹn dữ liệu
        $pdo->beginTransaction();

        // Thêm vào bảng borrowers
        $stmt = $pdo->prepare("INSERT INTO borrowers (name, email, phone) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $phone]);
        $borrower_id = $pdo->lastInsertId();

        // Thêm vào bảng users với role mặc định là 'borrower'
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, borrower_id) VALUES (?, ?, 'borrower', ?)");
        $stmt->execute([$username, $password, $borrower_id]);

        // Hoàn tất giao dịch
        $pdo->commit();
        $success = "Registration successful! Please log in.";
    } catch (PDOException $e) {
        // Rollback nếu có lỗi
        $pdo->rollBack();
        $error = "Registration failed: " . $e->getMessage();
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $error = "Email or username already exists.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Library Management</a>
            <div class="navbar-nav">
                <a class="nav-link" href="login.php">Login</a>
                <a class="nav-link active" href="register.php">Register</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="tel" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>