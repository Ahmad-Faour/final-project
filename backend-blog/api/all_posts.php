<?php
/** GET /api/all_posts.php
 *  Returns every post + comment count, newest first */
require_once __DIR__ . '/../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); echo json_encode(['error'=>'Method Not Allowed']); exit;
}

$sql = "SELECT p.*, COUNT(c.id) AS comment_count
        FROM posts p
        LEFT JOIN comments c ON c.post_id = p.id
        GROUP BY p.id
        ORDER BY p.created_at DESC";
echo json_encode($pdo->query($sql)->fetchAll());
