<?php
$data = file_get_contents('php://input');
$request = json_decode($data, true);

if (isset($request['file']) && isset($request['content'])) {
    $filePath = $request['file'];
    $newContent = $request['content'];

    /* ======= PROTECT LOGIN SNIPPET ======= */
    if (basename($filePath) === 'about_us.php') {
        $original = file_get_contents($filePath);

        if (preg_match(
                '/<!-- START_PROTECTED_LOGIN_SNIPPET -->(.*?)<!-- END_PROTECTED_LOGIN_SNIPPET -->/s',
                $original, $m
            )) {

            $protected = $m[0];        // cả block kèm comment

            if (preg_match(
                    '/<!-- START_PROTECTED_LOGIN_SNIPPET -->(.*?)<!-- END_PROTECTED_LOGIN_SNIPPET -->/s',
                    $newContent
                )) {
                /* ❶  Nếu người sửa vẫn giữ 2 comment:
                    thay thế toàn bộ phần giữa comment = bản gốc  */
                $newContent = preg_replace(
                    '/<!-- START_PROTECTED_LOGIN_SNIPPET -->(.*?)<!-- END_PROTECTED_LOGIN_SNIPPET -->/s',
                    $protected,
                    $newContent,
                    1                 // chỉ thay lần đầu
                );
            } else {
                /* ❷  Nếu họ lỡ xoá 2 comment:
                    thêm block gốc ngay trước thẻ </div> đóng .navbar-collapse */
                $newContent = preg_replace(
                    '/<\/div>\s*<\/div>\s*<\/nav>/s',
                    $protected . "\n</div></div></nav>",
                    $newContent,
                    1
                );
            }
        }
    }
    /* ===================================== */

    $allowedFiles = [
        '../bao/about_us.php',
        '../bao/forum.php',
        '../thinh/index.php',
        '../thinh/contact_us.php',
        '../kiet/blogs.php',
        '../kiet/detail.php'
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
