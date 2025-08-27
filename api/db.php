<?php
// api/db.php
declare(strict_types=1);
$DB_HOST = '127.0.0.1';
$DB_NAME = 'resume_builder';
$DB_USER = 'root';
$DB_PASS = ''; // XAMPP default

try {
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed', 'msg' => $e->getMessage()]);
    exit;
}
