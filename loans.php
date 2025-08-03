<?php
require_once 'config.php';

// Add loan
if (isset($_POST['add_loan'])) {
    $book_id = $_POST['book_id'];
    $borrower_id = $_POST['borrower_id'];
    $borrow_date = $_POST['borrow_date'] . ' ' . date('H:i:s'); // Thêm giờ hiện tại
    $stmt = $pdo->prepare("INSERT INTO loans (book_id, borrower_id, borrow_date, status) VALUES (?, ?, ?, 'borrowed')");
    $stmt->execute([$book_id, $borrower_id, $borrow_date]);
    // Update book quantity
    $pdo->prepare("UPDATE books SET quantity = quantity - 1 WHERE id = ?")->execute([$book_id]);
}

// Return book
if (isset($_GET['return'])) {
    $id = $_GET['return'];
    $stmt = $pdo->prepare("UPDATE loans SET status = 'returned', return_date = NOW() WHERE id = ?"); // Sử dụng NOW() để lấy cả giờ
    $stmt->execute([$id]);
    // Update book quantity
    $loan = $pdo->query("SELECT book_id FROM loans WHERE id = $id")->fetch();
    $pdo->prepare("UPDATE books SET quantity = quantity + 1 WHERE id = ?")->execute([$loan['book_id']]);
}

// Fetch all loans
$stmt = $pdo->query("SELECT l.id, b.title, br.name, l.borrow_date, l.return_date, l.status 
                     FROM loans l 
                     JOIN books b ON l.book_id = b.id 
                     JOIN borrowers br ON l.borrower_id = br.id");
$loans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch books and borrowers for dropdown
$books = $pdo->query("SELECT id, title FROM books WHERE quantity > 0")->fetchAll(PDO::FETCH_ASSOC);
$borrowers = $pdo->query("SELECT id, name FROM borrowers")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Loans</title>
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
                <a class="nav-link active" href="loans.php">Loans</a>
                <a class="nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Manage Loans</h2>
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label>Book</label>
                <select name="book_id" class="form-control" required>
                    <option value="">Select Book</option>
                    <?php foreach ($books as $book): ?>
                    <option value="<?php echo $book['id']; ?>"><?php echo $book['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Borrower</label>
                <select name="borrower_id" class="form-control" required>
                    <option value="">Select Borrower</option>
                    <?php foreach ($borrowers as $borrower): ?>
                    <option value="<?php echo $borrower['id']; ?>"><?php echo $borrower['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Borrow Date</label>
                <input type="datetime-local" name="borrow_date" class="form-control" required value="<?php echo date('Y-m-d\TH:i'); ?>">
            </div>
            <button type="submit" name="add_loan" class="btn btn-primary">Add Loan</button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book</th>
                    <th>Borrower</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?>
                <tr>
                    <td><?php echo $loan['id']; ?></td>
                    <td><?php echo $loan['title']; ?></td>
                    <td><?php echo $loan['name']; ?></td>
                    <td><?php echo $loan['borrow_date']; ?></td>
                    <td><?php echo $loan['return_date'] ?: 'Not Returned'; ?></td>
                    <td><?php echo $loan['status']; ?></td>
                    <td>
                        <?php if ($loan['status'] == 'borrowed'): ?>
                        <a href="loans.php?return=<?php echo $loan['id']; ?>" class="btn btn-success btn-sm">Return</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>