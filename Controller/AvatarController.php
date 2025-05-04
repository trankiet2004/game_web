<?php
// Controller/AvatarController.php
require_once __DIR__.'/../Model/DBConnect.php';

// Lấy id user từ query string
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $connect->prepare("SELECT avatar, avatar_type FROM users WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($blob, $mime);

if ($stmt->fetch() && $blob !== null) {
    header("Content-Type: $mime");
    echo $blob;
    exit;
}

// Nếu không tìm thấy hoặc chưa có avatar
header("HTTP/1.0 404 Not Found");
exit;
