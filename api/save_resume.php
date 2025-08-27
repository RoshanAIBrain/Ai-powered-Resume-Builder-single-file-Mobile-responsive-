<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'POST only']); exit; }
$input = json_decode(file_get_contents('php://input'), true);
if(!$input || !isset($input['data'])) { http_response_code(400); echo json_encode(['error'=>'bad payload']); exit; }

$user_id = $_SESSION['user_id'] ?? null;
$title = $input['title'] ?? ($input['data']['profile']['name'] ?? 'Untitled Resume');
$template = $input['template'] ?? ($input['data']['template'] ?? 'modern');
$color = $input['color'] ?? ($input['data']['color'] ?? '#4f46e5');
$dataJson = json_encode($input['data'], JSON_UNESCAPED_UNICODE);

try {
    if (!empty($input['id'])) {
        // update
        $stmt = $pdo->prepare("UPDATE resumes SET title = ?, template = ?, accent_color = ?, data = ? WHERE id = ?");
        $stmt->execute([$title, $template, $color, $dataJson, (int)$input['id']]);
        echo json_encode(['ok'=>true,'id'=>$input['id']]);
    } else {
        // insert
        $stmt = $pdo->prepare("INSERT INTO resumes (user_id,title,template,accent_color,data) VALUES (?,?,?,?,?)");
        $stmt->execute([$user_id, $title, $template, $color, $dataJson]);
        echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);
    }
} catch (PDOException $e) {
    http_response_code(500); echo json_encode(['error'=>'db error','msg'=>$e->getMessage()]);
}
