<?php
require_once 'config.php';

// Total books
$total_books = $pdo->query("SELECT COUNT(*) as count FROM books")->fetch()['count'];

// Total borrowers
$total_borrowers = $pdo->query("SELECT COUNT(*) as count FROM borrowers")->fetch()['count'];

// Total loans
$total_loans = $pdo->query("SELECT COUNT(*) as count FROM loans WHERE status = 'borrowed'")->fetch()['count'];

// Overdue loans with borrow_date and return_date
$overdue_loans = $pdo->query("SELECT l.id, b.title, br.name, l.borrow_date, l.return_date 
                              FROM loans l 
                              JOIN books b ON l.book_id = b.id 
                              JOIN borrowers br ON l.borrower_id = br.id 
                              WHERE l.status = 'borrowed' AND l.borrow_date < DATE_SUB(NOW(), INTERVAL 14 DAY)")
                      ->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Library Management</a>
            <div class="navbar-nav">
                <a class="nav-link" href="books.php">Books</a>
                <a class="nav-link" href="borrowers.php">Borrowers</a>
                <a class="nav-link" href="loans.php">Loans</a>
                <a class="nav-link active" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Library Reports</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Books</h5>
                        <p class="card-text"><?php echo $total_books; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Borrowers</h5>
                        <p class="card-text"><?php echo $total_borrowers; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Active Loans</h5>
                        <p class="card-text"><?php echo $total_loans; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="mt-4">Overdue Loans</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book</th>
                    <th>Borrower</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($overdue_loans as $loan): ?>
                <tr>
                    <td><?php echo $loan['id']; ?></td>
                    <td><?php echo $loan['title']; ?></td>
                    <td><?php echo $loan['name']; ?></td>
                    <td><?php echo $loan['borrow_date']; ?></td>
                    <td><?php echo $loan['return_date'] ?: 'Not Returned'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>