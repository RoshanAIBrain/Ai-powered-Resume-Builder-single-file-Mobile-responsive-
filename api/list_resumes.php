<?php
session_start();
header('Content-Type: application/json');
require 'db.php';
$user_id = $_SESSION['user_id'] ?? null;

try {
    if($user_id) {
        $stmt = $pdo->prepare("SELECT id,title,template,accent_color,created_at,updated_at FROM resumes WHERE user_id = ? ORDER BY updated_at DESC");
        $stmt->execute([$user_id]);
    } else {
        // if no auth, return ALL (or limited) — choose policy; here we return latest 10
        $stmt = $pdo->query("SELECT id,title,template,accent_color,created_at,updated_at FROM resumes ORDER BY updated_at DESC LIMIT 20");
    }
    $rows = $stmt->fetchAll();
    echo json_encode(['ok'=>true,'resumes'=>$rows]);
} catch (PDOException $e) {
    http_response_code(500); echo json_encode(['error'=>'db','msg'=>$e->getMessage()]);
}
