<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Library Management</a>
            <div class="navbar-nav">
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a class="nav-link" href="books.php">Books</a>
                    <a class="nav-link" href="borrowers.php">Borrowers</a>
                    <a class="nav-link" href="loans.php">Loans</a>
                    <a class="nav-link" href="reports.php">Reports</a>
                <?php else: ?>
                    <a class="nav-link" href="borrower_dashboard.php">Dashboard</a>
                <?php endif; ?>
                <a class="nav-link" href="logout.php">Logout</a>
                <a class="nav-link" href="register.php">Register</a> <!-- Thêm liên kết đăng ký -->
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Welcome to Library Management System</h1>
        <p>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                Use the navigation bar to manage books, borrowers, loans, or view reports.
            <?php else: ?>
                View available books and your loan history in the dashboard.
            <?php endif; ?>
        </p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>