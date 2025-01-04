<?php
$host = 'localhost';
$dbname = 'database_pj'; // 替換為您的資料庫名稱
$username = 'root'; // 替換為您的資料庫用戶名
$password = '0921009849'; // 替換為您的資料庫密碼

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
