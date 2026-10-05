<?php
// Supply these values in the local Apache/PHP environment; never commit credentials.
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$port = getenv('DB_PORT') ?: '3306';

if (!$host || !$dbname || !$username || $password === false || !ctype_digit($port)) {
    die('Database configuration is missing or invalid. Configure DB_HOST, DB_NAME, DB_USER, DB_PASSWORD, and DB_PORT locally.');
}

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed. Check the local database configuration.');
}
?>
