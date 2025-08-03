<?php
require_once 'config.php';

// Add borrower
if (isset($_POST['add_borrower'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $stmt = $pdo->prepare("INSERT INTO borrowers (name, email, phone) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $phone]);
}

// Delete borrower
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM borrowers WHERE id = ?");
    $stmt->execute([$id]);
}

// Fetch all borrowers
$stmt = $pdo->query("SELECT * FROM borrowers");
$borrowers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Borrowers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Library Management</a>
            <div class="navbar-nav">
                <a class="nav-link" href="books.php">Books</a>
                <a class="nav-link active" href="borrowers.php">Borrowers</a>
                <a class="nav-link" href="loans.php">Loans</a>
                <a class="nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Manage Borrowers</h2>
        <form method="POST" class="mb-4">
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
                <input type="text" name="phone" class="form-control">
            </div>
            <button type="submit" name="add_borrower" class="btn btn-primary">Add Borrower</button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowers as $borrower): ?>
                <tr>
                    <td><?php echo $borrower['id']; ?></td>
                    <td><?php echo $borrower['name']; ?></td>
                    <td><?php echo $borrower['email']; ?></td>
                    <td><?php echo $borrower['phone']; ?></td>
                    <td>
                        <a href="borrowers.php?delete=<?php echo $borrower['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>