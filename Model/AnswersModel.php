<?php
require_once __DIR__ . '/DBConnect.php';

class AnswersModel {
    private $conn;

    public function __construct() {
        global $connect;
        $this->conn = $connect;
    }

    public function insertAnswer(int $faq_id, int $user_id, string $content): bool {
        $sql = "INSERT INTO answers (faq_id, user_id, content, created_at) 
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        if ( ! $stmt) return false;
        $stmt->bind_param("iis", $faq_id, $user_id, $content);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getAnswersByFaqId(int $faq_id): array {
        $sql = "SELECT 
                    a.answer_id, 
                    a.faq_id, 
                    a.user_id, 
                    a.content, 
                    a.created_at,
                    u.username AS user_name
                FROM answers a
                JOIN users u ON a.user_id = u.id
                WHERE a.faq_id = ?
                ORDER BY a.created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $faq_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $out = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $out;
    }
}