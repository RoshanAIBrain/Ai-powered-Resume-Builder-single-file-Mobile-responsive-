<?php
session_start();
header('Content-Type: application/json');
require 'db.php';
$input = json_decode(file_get_contents('php://input'), true);
if(!$input || empty($input['email']) || empty($input['password'])) {
    http_response_code(400); echo json_encode(['error'=>'missing fields']); exit;
}
$email = $input['email']; $password = $input['password'];
$stmt = $pdo->prepare('SELECT id, password_hash, name FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]); $user = $stmt->fetch();
if(!$user || !password_verify($password, $user['password_hash'])) {
    http_response_code(401); echo json_encode(['error'=>'invalid credentials']); exit;
}
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
echo json_encode(['ok'=>true,'user_id'=>$user['id'],'name'=>$user['name']]);
