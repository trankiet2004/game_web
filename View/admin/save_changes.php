<?php
$data = file_get_contents('php://input');
$request = json_decode($data, true);

if (isset($request['file']) && isset($request['content'])) {
    $filePath = $request['file'];
    $newContent = $request['content'];

    $allowedFiles = [
        '../bao/about_us.html',
        '../bao/forum.html',
        '../thinh/index.html',
        '../thinh/contact_us.html',
        '../kiet/blogs.html',
        '../kiet/detail.html'
    ];
    
    if (!in_array($filePath, $allowedFiles)) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Không được phép chỉnh sửa file này']);
        exit;
    }
    
    if (file_put_contents($filePath, $newContent) !== false) {
        echo json_encode(['status' => 'success', 'message' => 'Lưu thay đổi thành công']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Lỗi khi ghi file']);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
}
?>
