<?php
session_start();

// Chỉ POST mới được lưu
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.0 405 Method Not Allowed');
    exit('Method Not Allowed');
}
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền');
}

require_once __DIR__ . '/../Model/DBConnect.php';

// Hàm parse Markdown-nhẹ: đoạn ngắt bằng 2 newline → <p>, #… → <h1>..</h1>
function parseContent(string $raw): string {
    $lines  = preg_split('/\r\n|\n|\r/', trim($raw));
    $html   = '';
    $buf    = '';
    foreach ($lines as $line) {
        if (preg_match('/^(#{1,6})\s+(.*)$/', $line, $m)) {
            // flush buffer
            if ($buf!=='') {
                $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
                $buf = '';
            }
            $lvl  = min(strlen($m[1]),6);
            $txt  = htmlspecialchars(trim($m[2]));
            $html .= "<h{$lvl}>{$txt}</h{$lvl}>";
        }
        elseif (trim($line)==='') {
            if ($buf!=='') {
                $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
                $buf = '';
            }
        }
        else {
            $buf .= $line ."\n";
        }
    }
    if ($buf!=='') {
        $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
    }
    return $html;
}

// Nhận dữ liệu
$title   = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');

// Validate
if ($title === '' || $content==='') {
    header('Location: ../index.php?page=create_article&error=Thiếu+tiêu+đề+hoặc+nội+dung');
    exit;
}

// Parse nội dung
$htmlBody = parseContent($content);

// Xử lý ảnh
$imgData = null; $imgType = null;
if (!empty($_FILES['image']['tmp_name'])) {
    $imgData = file_get_contents($_FILES['image']['tmp_name']);
    $imgType = mime_content_type($_FILES['image']['tmp_name']);
}

// Lưu vào DB
$stmt = $connect->prepare("
    INSERT INTO articles
      (title, content, author, time, image)
    VALUES (?, ?, ?, NOW(), ?)
");
$stmt->bind_param('ssss',
    $title,
    $htmlBody,
    $_SESSION['user']['username'],
    $imgData
);
// Nếu là blob, send_long_data
if ($imgData !== null) {
    $stmt->send_long_data(3, $imgData);
}
if (!$stmt->execute()) {
    $err = $stmt->error;
    header('Location: ../index.php?page=create_article&error='.urlencode($err));
    exit;
}

// Thành công
header('Location: ../index.php?page=kiet_blog_manage&msg=' . urlencode('Đã tạo mới bài viết'));
exit;
