<?php
/** GET /api/post_by_id.php
 *  Body: { "id": <post_id> } → returns post + latest 15 comments */
require_once __DIR__ . '/../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); echo json_encode(['error'=>'Method Not Allowed']); exit;
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$postId  = $payload['id'] ?? null;
if (!$postId) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; }

$post = $pdo->prepare("SELECT * FROM posts WHERE id=?");
$post->execute([$postId]);
$post = $post->fetch();
if (!$post) { http_response_code(404); echo json_encode(['error'=>'Post not found']); exit; }

$comments = $pdo->prepare("
    SELECT c.*, u.name AS user_name
    FROM comments c
    JOIN users u ON u.id = c.user_id
    WHERE c.post_id = ?
    ORDER BY c.created_at DESC
    LIMIT 15
");
$comments->execute([$postId]);

echo json_encode(['post'=>$post,'comments'=>$comments->fetchAll()]);
