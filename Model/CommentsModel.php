<?php
require_once('DBConnect.php');

class CommentsModel {
    public function getCommentsByArticle($articleId) {
        global $connect;
        $stmt = $connect->prepare("SELECT * FROM blog_comment WHERE article_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        return $comments;
    }

    public function addComment($articleId, $userId, $userName, $content) {
        global $connect;
        $stmt = $connect->prepare("INSERT INTO blog_comment(article_id, user_id, user_name, content, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiss", $articleId, $userId, $userName, $content);
        return $stmt->execute();
    }
}
