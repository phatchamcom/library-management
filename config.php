<?php
$host = 'localhost';
$dbname = 'library';
$username = 'root';
$password = ''; // Mặc định XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Debug: Xác nhận kết nối
    // echo "Database connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>