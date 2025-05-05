<?php
session_start();

// 1) Chỉ cho phép admin POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST'
 || !isset($_GET['action']) || $_GET['action'] !== 'store'
) {
    header('HTTP/1.0 405 Method Not Allowed');
    exit('Method Not Allowed');
}
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền');
}

// Kết nối DB
require_once __DIR__ . '/../Model/DBConnect.php';

// Nhận dữ liệu
$title   = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');

if ($title === '' || $content === '') {
    header('Location: /index.php?page=create_article&error=' . urlencode('Thiếu tiêu đề hoặc nội dung'));
    exit;
}

// Parse nội dung: ngắt đoạn 2 newline → <p>, # Heading → <hN>
function parseContent(string $raw): string {
    $lines = preg_split('/\r\n|\n|\r/', trim($raw));
    $html  = ''; $buf = '';
    foreach ($lines as $line) {
        if (preg_match('/^(#{1,6})\s+(.*)$/', $line, $m)) {
            if ($buf !== '') {
                $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
                $buf = '';
            }
            $lvl = min(strlen($m[1]), 6);
            $html .= "<h{$lvl}>". htmlspecialchars(trim($m[2])) ."</h{$lvl}>";
        } elseif (trim($line) === '') {
            if ($buf !== '') {
                $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
                $buf = '';
            }
        } else {
            $buf .= $line ."\n";
        }
    }
    if ($buf !== '') {
        $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
    }
    return $html;
}

$htmlBody = parseContent($content);

// Xử lý upload ảnh: lưu vào /View/img/blogsImg và chỉ giữ đường dẫn
$imagePath = null;
if (!empty($_FILES['image']['tmp_name'])) {
    $uploadDir = __DIR__ . '/../View/img/blogsImg/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    // đặt tên file tránh trùng
    $ext      = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $dest     = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        // đường dẫn public (tùy theo base của bạn)
        $imagePath = '/View/img/blogsImg/' . $filename;
    }
}

// Chèn vào DB
$stmt = $connect->prepare("
    INSERT INTO articles
      (title, content, author, time, image)
    VALUES (?, ?, ?, NOW(), ?)
");
$stmt->bind_param(
    'ssss',
    $title,
    $htmlBody,
    $_SESSION['user']['username'],
    $imagePath
);

if (!$stmt->execute()) {
    $err = $stmt->error;
    header('Location: /index.php?page=create_article&error=' . urlencode($err));
    exit;
}

// Thành công → luôn redirect về index.php
header('Location: /index.php?page=kiet_blog_manage&msg=' . urlencode('Đã tạo bài viết thành công'));
exit;
