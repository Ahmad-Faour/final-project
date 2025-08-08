<?php
/** DELETE /api/delete_post.php
 *  Body: { "id": <post_id> } */
require_once __DIR__ . '/../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); echo json_encode(['error'=>'Method Not Allowed']); exit;
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$pid = $payload['id'] ?? null;
if (!$pid) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; }

$ok = $pdo->prepare("DELETE FROM posts WHERE id=?")->execute([$pid]);
echo json_encode(['status'=>'success','deleted'=>$ok]);
