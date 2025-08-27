<?php
header('Content-Type: application/json');
require 'db.php';
$input = json_decode(file_get_contents('php://input'), true);
if(!$input || empty($input['email']) || empty($input['password']) || empty($input['name'])) {
    http_response_code(400); echo json_encode(['error'=>'missing fields']); exit;
}
$email = $input['email'];
$name = $input['name'];
$pass = password_hash($input['password'], PASSWORD_DEFAULT);
try {
    $stmt = $pdo->prepare('INSERT INTO users (name,email,password_hash) VALUES (?, ?, ?)');
    $stmt->execute([$name,$email,$pass]);
    echo json_encode(['ok'=>true,'user_id'=>$pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(400);
    echo json_encode(['error'=>'could not create user','msg'=>$e->getMessage()]);
}
