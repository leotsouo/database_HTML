# database_HTML

README: 測試資料庫連接\n
專案簡介
此文件旨在指導團隊成員如何測試與資料庫 database_pj 的連接是否成功。

系統需求
安裝好的 XAMPP（包含 Apache 和 MySQL）
可用的資料庫 database_pj
團隊成員的資料庫帳號與密碼
連線資訊
請根據以下資料配置連接：

伺服器地址：192.168.137.1
資料庫名稱：database_pj
用戶名稱：teammate_user
密碼：sharepoor
端口：3306

測試連線步驟
1. 創建測試檔案

<?php
$servername = "192.168.137.1"; // 替換為伺服器 IP
$username = "teammate_user";
$password = "sharepoor";
$dbname = "database_pj";

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
echo "成功連接到資料庫 " . $dbname;
$conn->close();
?>

在瀏覽器中輸入：http://192.168.137.1/test_connection.php
