# database_HTML

資料庫課程專案：專題提交、隊伍註冊與評分介面的 HTML / PHP 原型。

## 測試資料庫連接

以下說明保留團隊本機開發的連線測試流程。連線資料請向專案維護者取得，並以本機環境變數提供；不要把真實帳號或密碼寫入 README 或提交到 Git。

### 系統需求

- XAMPP（Apache、PHP 與 MySQL）
- 已建立的專案資料庫
- 你有權使用的資料庫帳號

### 本機環境變數

在本機 Apache / PHP 執行環境設定以下變數：

- `DB_HOST`：你的資料庫主機
- `DB_NAME`：你的資料庫名稱
- `DB_USER`：你的資料庫使用者
- `DB_PASSWORD`：你的資料庫密碼
- `DB_PORT`：資料庫連接埠（通常為 `3306`）

### 測試連線步驟

在本機網站目錄建立 `test_connection.php`，使用下列範例：

```php
<?php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_NAME');
$port = (int) (getenv('DB_PORT') ?: 3306);

if (!$host || !$user || $password === false || !$database) {
    http_response_code(500);
    exit('請先設定本機資料庫環境變數。');
}

try {
    $conn = new mysqli($host, $user, $password, $database, $port);
    if ($conn->connect_error) {
        throw new RuntimeException('Database connection failed');
    }
    echo '成功連接到資料庫';
    $conn->close();
} catch (Throwable $e) {
    http_response_code(500);
    echo '連接失敗，請在本機檢查資料庫設定。';
}
?>
```

啟動本機 Apache 與 MySQL，瀏覽 `http://localhost/test_connection.php`。測試完成後移除測試頁面。

> 此範例僅用於連線測試，不會自動修改專案現有的資料庫設定檔。
