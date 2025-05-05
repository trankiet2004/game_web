<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php?page=signin');
    exit;
}
if (($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Không có quyền.');
}

require_once __DIR__ . '/../Model/DBConnect.php';

// parse nội dung từ textarea → HTML
function parseContent(string $raw): string {
    $lines = preg_split('/\r\n|\n|\r/', trim($raw));
    $html  = ''; $buf = '';
    foreach ($lines as $line) {
        if (preg_match('/^(#{1,6})\s+(.*)$/',$line,$m)) {
            if ($buf!=='') {
                $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
                $buf = '';
            }
            $lvl = min(strlen($m[1]),6);
            $html .= "<h{$lvl}>".htmlspecialchars($m[2])."</h{$lvl}>";
        } elseif (trim($line)==='') {
            if ($buf!=='') {
                $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
                $buf = '';
            }
        } else {
            $buf .= $line."\n";
        }
    }
    if ($buf !== '') {
        $html .= '<p>'. nl2br(htmlspecialchars(trim($buf))) .'</p>';
    }
    return $html;
}

$action = $_GET['action'] ?? '';
switch ($action) {

case 'update':
    $id      = (int)($_GET['id'] ?? 0);
    $title   = trim($_POST['title'] ?? '');
    $raw     = trim($_POST['content'] ?? '');
    if (!$id || !$title || !$raw) {
        header("Location: ../index.php?page=edit_article&id={$id}&error=Thiếu dữ liệu");
        exit;
    }
    $content = parseContent($raw);

    // xử lý ảnh
    $imgPath = null;
    $remove  = isset($_POST['remove_image']);
    if ($remove) {
        // xóa file cũ
        $stmt = $connect->prepare("SELECT image FROM articles WHERE id=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        if ($row = $stmt->get_result()->fetch_assoc()) {
            @unlink(__DIR__.'/../View/img/blogsImg/'.basename($row['image']));
        }
        $stmt->close();
    }
    if (!empty($_FILES['image']['tmp_name'])) {
        $fname = time().'_'.basename($_FILES['image']['name']);
        $dest  = __DIR__.'/../View/img/blogsImg/'.$fname;
        move_uploaded_file($_FILES['image']['tmp_name'], $dest);
        $imgPath = '/View/img/blogsImg/'.$fname;
    }

    // Build SQL dynamic
    $sql = "UPDATE articles SET title=?, content=?";
    $types = "ss"; $params = [&$title,&$content];
    if ($remove) {
        $sql .= ", image=NULL";
    }
    if ($imgPath) {
        $sql .= ", image=?";
        $types .= "s";
        $params[] = &$imgPath;
    }
    $sql .= " WHERE id=?";
    $types .= "i";
    $params[] = &$id;

    $stmt = $connect->prepare($sql);
    array_unshift($params, $types);
    call_user_func_array([$stmt,'bind_param'], $params);
    $stmt->execute();
    $stmt->close();

    header("Location: /index.php?page=kiet_blog_manage&msg=".urlencode('Cập nhật thành công'));
    exit;

case 'delete_comment':
    $cid = (int)($_GET['id'] ?? 0);
    $aid = (int)($_GET['article_id'] ?? 0);
    if ($cid && $aid) {
        $d = $connect->prepare("DELETE FROM comments WHERE id=?");
        $d->bind_param('i',$cid);
        $d->execute();
        $d->close();
    }
    header("Location: /index.php?page=edit_article&id={$aid}&msg=".urlencode('Đã xóa bình luận'));
    exit;

default:
    http_response_code(400);
    echo "Action không hợp lệ.";
    exit;
}
