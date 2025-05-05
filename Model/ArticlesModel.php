<?php
require_once('DBConnect.php');

class ArticlesModel {
    private $connect;

    public function __construct() {
        global $connect;
        $this->connect = $connect;
    }

    public function GET($table, $id, $idColumn) {
        header("Content-type: application/json");
    
        try {
            // Bước 1: Lấy danh sách các cột, trừ 'image'
            $exclude = ['image'];
            $placeholders = implode(',', array_fill(0, count($exclude), '?'));
            $types = str_repeat('s', count($exclude));
    
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_NAME = ? AND TABLE_SCHEMA = DATABASE()";
            if (!empty($exclude)) {
                $sql .= " AND COLUMN_NAME NOT IN ($placeholders)";
            }
    
            $stmt = $this->connect->prepare($sql);
            if (!empty($exclude)) {
                $stmt->bind_param('s' . $types, $table, ...$exclude);
            } else {
                $stmt->bind_param('s', $table);
            }
    
            $stmt->execute();
            $res = $stmt->get_result();
            $columns = [];
            while ($row = $res->fetch_assoc()) {
                $columns[] = $row['COLUMN_NAME'];
            }
            if (empty($columns)) throw new Exception("Không lấy được danh sách cột từ bảng $table");
    
            $columnList = implode(',', $columns);
    
            // Bước 2: Tạo câu truy vấn đúng như logic gốc
            $SQL = $id === null
                ? "SELECT $columnList FROM $table"
                : "SELECT $columnList FROM $table WHERE $idColumn = $id";
    
            $query = $this->connect->query($SQL);
            if (!$query) {
                throw new Exception("Query execution failed: " . $this->connect->error);
            }
    
            // Bước 3: Trả về JSON
            $jsonResponse = [];
            while ($row = $query->fetch_assoc()) {
                $jsonResponse[] = $row;
            }
    
            http_response_code(200);
            echo json_encode($jsonResponse);
        } catch (mysqli_sql_exception $e) {
            http_response_code(500);
            echo json_encode([
                "error" => "SQL Error: " . $e->getMessage()
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "error" => "An unexpected error occured: " . $e->getMessage()
            ]);
        }
    }    

    public function POST($table, $json) {
        if($table === "faqs") {
            $question = $json[0];
            $answer = $json[1];
            $posted_by = $json[2];
            $stmt = $this->connect->prepare("INSERT INTO faqs (question, answer, posted_by) VALUES (?, ?, ?)");
            
            if($stmt === false) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Prepare statement thất bại: " . $this->connect->error]);
                exit;
            }

            $stmt->bind_param("sss", $question, $answer, $posted_by);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Câu hỏi đã được cập nhật thành công"]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Có lỗi xảy ra: " . $stmt->error]);
            }

            $stmt->close();
        }
    }

    public function fetch($method, $table, $id, $idColumn = "id", $json = NULL) {
        switch ($method) {
            case "GET":
                $this->GET($table, $id, $idColumn);
                break;

            case "POST":
                $this->POST($table, $json);
                break;
        }
    }
}