<?php
require_once(__DIR__ . '/../Model/CommentsModel.php');
header("Content-Type: application/json");

$model = new CommentsModel();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (!isset($_GET['article_id'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Thiếu article_id"]);
            exit;
        }
        $articleId = intval($_GET['article_id']);
        $comments = $model->getCommentsByArticle($articleId);
        echo json_encode($comments);
        break;

    case 'POST':
        // Debug in toàn bộ POST xem có dữ liệu không
        $debug_post = [
            'article_id' => $_POST['article_id'] ?? 'null',
            'user_id'    => $_POST['user_id'] ?? 'null',
            'user_name'  => $_POST['user_name'] ?? 'null',
            'content'    => $_POST['content'] ?? 'null'
        ];

        // Nếu thiếu bất kỳ trường nào thì trả lỗi chi tiết
        if (
            !isset($_POST['article_id']) || !isset($_POST['user_id']) ||
            !isset($_POST['content']) || trim($_POST['content']) === ''
        ) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Thiếu dữ liệu",
                "debug" => $debug_post
            ]);
            exit;
        }

        $articleId = (int) $_POST['article_id'];
        $userId = (int) $_POST['user_id'];
        $userName = $_POST['user_name'];
        $content = $_POST['content'];

        $success = $model->addComment($articleId, $userId, $userName, $content);
        echo json_encode(["success" => $success]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Method not allowed"]);
        break;
}