<?php
/** PUT /api/update_comment.php
 *  Body: { "id": <comment_id>, "content": "new text" } */
require_once __DIR__ . '/../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405); echo json_encode(['error'=>'Method Not Allowed']); exit;
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$cid = $payload['id'] ?? null;
$txt = $payload['content'] ?? null;
if (!$cid || !$txt) { http_response_code(400); echo json_encode(['error'=>'id & content required']); exit; }

$ok = $pdo->prepare("UPDATE comments SET content=? WHERE id=?")->execute([$txt,$cid]);
echo json_encode(['status'=>'success','updated'=>$ok]);
