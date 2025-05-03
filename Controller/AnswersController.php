<?php
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../Model/AnswersModel.php';
$model = new AnswersModel();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (empty($_GET['faq_id'])) {
        http_response_code(400);
        echo json_encode(['success'=>false,'message'=>'Thiếu faq_id']);
        exit;
    }
    $faq_id = (int) $_GET['faq_id'];
    $answers = $model->getAnswersByFaqId($faq_id);
    echo json_encode($answers);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không hợp lệ'
    ]);
    exit;
}

if (
    empty($_POST['faq_id']) ||
    empty($_POST['user_id']) ||
    empty($_POST['answer'])
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu dữ liệu bắt buộc'
    ]);
    exit;
}

$faq_id  = (int) $_POST['faq_id'];
$user_id = (int) $_POST['user_id'];
$content = trim($_POST['answer']);

if (!isset($_SESSION['user']) || $user_id !== (int) $_SESSION['user']['id']) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Bạn chưa đăng nhập hoặc không có quyền'
    ]);
    exit;
}

if ($model->insertAnswer($faq_id, $user_id, $content)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi khi lưu câu trả lời vào cơ sở dữ liệu'
    ]);
}
