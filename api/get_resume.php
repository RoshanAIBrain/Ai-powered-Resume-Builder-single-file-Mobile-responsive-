<?php
session_start();
header('Content-Type: application/json');
require 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id){ http_response_code(400); echo json_encode(['error'=>'missing id']); exit; }
try {
    $stmt = $pdo->prepare("SELECT id,user_id,title,template,accent_color,data,created_at,updated_at FROM resumes WHERE id = ? LIMIT 1");
    $stmt->execute([$id]); $row = $stmt->fetch();
    if(!$row) { http_response_code(404); echo json_encode(['error'=>'not found']); exit; }
    $row['data'] = json_decode($row['data'], true);
    echo json_encode(['ok'=>true,'resume'=>$row]);
} catch (PDOException $e) {
    http_response_code(500); echo json_encode(['error'=>'db','msg'=>$e->getMessage()]);
}
