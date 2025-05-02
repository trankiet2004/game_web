<?php
require_once('DBConnect.php');

class GamesModel
{
    private $connect;

    public function __construct()
    {
        global $connect;
        $this->connect = $connect;
    }
    public function GET($table, $id, $idColumn)
    {
        header("Content-type: application/json");

        try {
            $SQL = $id === null ? "SELECT * FROM $table" : "SELECT * FROM $table WHERE $idColumn = $id";
            $query = $this->connect->query($SQL);

            if (!$query) {
                throw new Exception("Query execution failed: " . $this->connect->error);
            }

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

    public function POST($table, $json)
    {
        if ($table === "faqs") {
            $question = $json[0];
            $answer = $json[1];
            $posted_by = $json[2];
            $stmt = $this->connect->prepare("INSERT INTO faqs (question, answer, posted_by) VALUES (?, ?, ?)");

            if ($stmt === false) {
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

    public function fetch($method, $table, $id, $idColumn = "id", $json = NULL)
    {
        switch ($method) {
            case "GET":
                $this->GET($table, $id, $idColumn);
                break;

            case "POST":
                $this->POST($table, $json);
                break;
        }
    }
    public function get_products($sort, $filter, $limit, $offset)
    {
        $params = [];
        $types = '';
        $sql = "SELECT * FROM games WHERE 1";

        // Search filter
        if (!empty($filter['title'])) {
            $sql .= " AND name LIKE ?";
            $params[] = "%" . $filter['title'] . "%";
            $types .= 's';  // This ensures we bind a string parameter for the LIKE clause
        }

        // Sorting
        $allowed_columns = ['released', 'price', 'name', 'rating', 'metacritic'];
        $sort_by = in_array($sort['by'], $allowed_columns) ? $sort['by'] : 'released';
        $sort_order = strtoupper($sort['order']) === 'ASC' ? 'ASC' : 'DESC';
        $sql .= " ORDER BY $sort_by $sort_order";

        // Pagination
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';  // This ensures we bind integer parameters for limit and offset

        $stmt = $this->connect->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $games = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $games;  // Return the result
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Database error: " . $this->connect->error]);
        }
    }

    public function get_total_count($filter)
    {
        $params = [];
        $types = '';
        $sql = "SELECT COUNT(*) as total FROM games WHERE 1";

        // Search filter
        if (!empty($filter['title'])) {
            $sql .= " AND name LIKE ?";
            $params[] = "%" . $filter['title'] . "%";
            $types .= 's';
        }

        $stmt = $this->connect->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row ? (int) $row['total'] : 0;
    }

    public function get_game_by_id($id) {
        $stmt = $this->connect->prepare("SELECT * FROM games WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}


