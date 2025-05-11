<?php
session_start();

// 1. Chưa login → về signin
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php?page=signin');
    exit;
}

// 2. Không phải admin → 403
if (($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền thực hiện thao tác này.');
}

// 3. Lấy id và validate
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $msg = 'ID bài viết không hợp lệ.';
    header("Location: /index.php?page=kiet_blog_manage&msg=" . urlencode($msg));
    exit;
}

// 4. Xóa bài viết
require_once __DIR__ . '/../../Model/DBConnect.php';  // sửa theo đúng path của bạn

$stmt = $connect->prepare("DELETE FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $msg = "Xóa bài viết #{$id} thành công.";
} else {
    $msg = "Lỗi khi xóa bài viết: " . $stmt->error;
}

$stmt->close();

// 5. Redirect về trang quản lý
header("Location: /index.php?page=kiet_blog_manage&msg=" . urlencode($msg));
exit;
