<?php
require_once('DBConnect.php');

class FaqsModel {
    private $connect;

    public function __construct() {
        global $connect;
        $this->connect = $connect;
    }

    public function GET($table, $id, $idColumn) {
        header("Content-type: application/json");

        try {
            $SQL = $id === null ? "SELECT * FROM $table" : "SELECT * FROM $table WHERE $idColumn = $id";
            $query = $this->connect->query($SQL);

            if(!$query) {
                throw new Exception("Query execution failed: " . $this->connect->error);
            }

            $jsonResponse = [];
            while($row = $query->fetch_assoc()) {
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
            $user_id = $json[2];
            $posted_by = $json[3];
            $stmt = $this->connect->prepare("INSERT INTO faqs (question, answer, user_id, posted_by) VALUES (?, ?, ?, ?)");
            
            if($stmt === false) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Prepare statement thất bại: " . $this->connect->error]);
                exit;
            }

            $stmt->bind_param("ssss", $question, $answer, $user_id, $posted_by);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Câu hỏi đã được cập nhật thành công"]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Có lỗi xảy ra: " . $stmt->error]);
            }

            $stmt->close();
        }
    }

    public function DELETE($faqId) {
        $stmt = $this->connect->prepare("DELETE FROM faqs WHERE faq_id = ?");
        $stmt->bind_param("i", $faqId);
        return $stmt->execute();
    }

    public function fetch($method, $table, $id, $idColumn = "id", $json = NULL) {
        switch ($method) {
            case "GET":
                $this->GET($table, $id, $idColumn);
                break;

            case "POST":
                $this->POST($table, $json);
                break;

            case "DELETE":
                $this->DELETE($id);
                header('Content-Type: application/json');
                echo json_encode(['success'=>true]);  
                break;
        }
    }
}