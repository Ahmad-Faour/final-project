<?php
/** GET /api/user_posts.php
 *  Body: { "user_id": <id> } → latest 10 posts by that user */
require_once __DIR__ . '/../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); echo json_encode(['error'=>'Method Not Allowed']); exit;
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$uid = $payload['user_id'] ?? null;
if (!$uid) { http_response_code(400); echo json_encode(['error'=>'user_id required']); exit; }

$stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id=? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$uid]);
echo json_encode($stmt->fetchAll());
