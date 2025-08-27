<?php
session_start();
header('Content-Type: application/json');
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'POST only']); exit; }
$input = json_decode(file_get_contents('php://input'), true);
$id = isset($input['id']) ? (int)$input['id'] : 0;
if(!$id) { http_response_code(400); echo json_encode(['error'=>'missing id']); exit; }
try {
    $stmt = $pdo->prepare("DELETE FROM resumes WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['ok'=>true]);
} catch (PDOException $e) {
    http_response_code(500); echo json_encode(['error'=>'db','msg'=>$e->getMessage()]);
}
