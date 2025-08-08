<?php
/* PDO connection helper – adjust credentials if needed */
$host = '127.0.0.1';
$db   = 'blog_api';
$user = 'root';   // default XAMPP user
$pass = '';       // default XAMPP password = empty
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opts = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $opts);
    //echo "connected";
} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['status'=>'error','message'=>'DB connection failed']);
    exit;
}
