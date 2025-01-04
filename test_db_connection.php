<?php
// 資料庫連接參數
$host = 'localhost'; // 資料庫主機名
$dbname = 'database_pj'; // 資料庫名稱
$username = 'root'; // 資料庫用戶名
$password = '0921009849'; // 資料庫密碼

try {
    // 建立PDO連接
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "資料庫連接成功！";
} catch (PDOException $e) {
    // 連接失敗時顯示錯誤信息
    echo "資料庫連接失敗：" . $e->getMessage();
}
?>
