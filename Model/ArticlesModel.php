<?php
// Model/ArticlesModel.php
require_once 'DBConnect.php';

class ArticlesModel {
    private $connect;

    public function __construct() {
        global $connect;
        $this->connect = $connect;
    }

    /**
     * Xử lý GET: nếu $id=null thì trả về full list, ngược lại trả về 1 record
     */
    public function GET(string $table, $id = null, string $idColumn = 'id') {
        header("Content-Type: application/json; charset=utf-8");

        try {
            if ($id === null) {
                // Lấy toàn bộ
                $sql  = "SELECT id, title, content, author, time, image
                         FROM `$table`
                         ORDER BY time DESC";
                $stmt = $this->connect->prepare($sql);
            } else {
                // Lấy theo id
                $sql  = "SELECT id, title, content, author, time, image
                         FROM `$table`
                         WHERE `$idColumn` = ?";
                $stmt = $this->connect->prepare($sql);
                $stmt->bind_param('i', $id);
            }

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $res    = $stmt->get_result();
            $rows   = $res->fetch_all(MYSQLI_ASSOC);

            // JSON encode và output
            echo json_encode($rows, JSON_UNESCAPED_UNICODE);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Xử lý POST cho table 'faqs' (nếu bạn có)
     */
    public function POST($table, $json) {
        if ($table !== 'faqs') {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>'Unsupported POST table']);
            exit;
        }

        list($question, $answer, $posted_by) = $json;
        $stmt = $this->connect->prepare(
            "INSERT INTO faqs (question, answer, posted_by) VALUES (?, ?, ?)"
        );
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(['success'=>false,'message'=>"Prepare failed: ".$this->connect->error]);
            exit;
        }
        $stmt->bind_param('sss', $question, $answer, $posted_by);
        if ($stmt->execute()) {
            echo json_encode(['success'=>true,'message'=>'Câu hỏi đã được cập nhật thành công']);
        } else {
            http_response_code(500);
            echo json_encode(['success'=>false,'message'=>'Execute failed: '.$stmt->error]);
        }
        exit;
    }

    /**
     * Router đơn giản: GET / POST
     */
    public function fetch(string $method, string $table, $id = null, string $idColumn = 'id', array $json = null) {
        if (strtoupper($method) === 'GET') {
            $this->GET($table, $id, $idColumn);
        } elseif (strtoupper($method) === 'POST') {
            $this->POST($table, $json);
        } else {
            http_response_code(405);
            echo json_encode(['error'=>'Method Not Allowed']);
            exit;
        }
    }
}
