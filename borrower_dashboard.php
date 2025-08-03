<?php
session_start();
require_once 'config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Kiểm tra quyền borrower
if ($_SESSION['role'] !== 'borrower') {
    die("Access denied: Borrowers only");
}

// Lấy borrower_id từ user
$stmt = $pdo->prepare("SELECT borrower_id FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$borrower_id = $stmt->fetchColumn();

// Lấy danh sách sách
$books = $pdo->query("SELECT * FROM books WHERE quantity > 0")->fetchAll(PDO::FETCH_ASSOC);

// Lấy lịch sử mượn
$loans = $pdo->query("SELECT l.id, b.title, l.borrow_date, l.return_date, l.status 
                      FROM loans l 
                      JOIN books b ON l.book_id = b.id 
                      WHERE l.borrower_id = $borrower_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrower Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Library Management</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="borrower_dashboard.php">Dashboard</a>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Borrower Dashboard</h2>
        <h3>Available Books</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo $book['id']; ?></td>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo $book['author']; ?></td>
                    <td><?php echo $book['quantity']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Your Loans</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?>
                <tr>
                    <td><?php echo $loan['id']; ?></td>
                    <td><?php echo $loan['title']; ?></td>
                    <td><?php echo $loan['borrow_date']; ?></td>
                    <td><?php echo $loan['return_date'] ?: 'Not Returned'; ?></td>
                    <td><?php echo $loan['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>