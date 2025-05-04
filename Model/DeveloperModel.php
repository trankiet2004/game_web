<?php
require_once('DBConnect.php');

class DevelopersModel {
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

    public function get_total_count($filter)
    {
        $params = [];
        $types = '';
        $sql = "SELECT COUNT(*) as total FROM developers WHERE 1";

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

    public function get_developers($sort, $filter, $limit, $offset)
    {
        $params = [];
        $types = '';
        $sql = "SELECT * FROM developers WHERE 1";

        // Search filter
        if (!empty($filter['title'])) {
            $sql .= " AND name LIKE ?";
            $params[] = "%" . $filter['title'] . "%";
            $types .= 's';
        }

        // Sorting: Only A-Z or Z-A by name
        $sort_order = strtoupper($sort['order']) === 'ASC' ? 'ASC' : 'DESC';
        $sql .= " ORDER BY name $sort_order";

        // Pagination
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';

        $stmt = $this->connect->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $developers = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $developers;
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Database error: " . $this->connect->error]);
            return [];
        }
    }
    public function get_developer_by_id($id, $limit = 5, $offset = 0)
    {
        // Get developer info
        $sql = "SELECT * FROM developers WHERE id = ?";
        $stmt = $this->connect->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $developer = $result->fetch_assoc();
            $stmt->close();

            if ($developer) {
                // Get total games count
                $developer['game_count'] = $this->get_game_count_by_developer($id);

                // Get first games with limit & offset
                $developer['games'] = $this->get_games_by_developer($id, $limit, $offset);
            }

            return $developer;
        }

        http_response_code(500);
        echo json_encode(["error" => "Database error: " . $this->connect->error]);
        return null;
    }


    public function get_games_by_developer($developer_id, $limit, $offset)
    {
        $sql = "
        SELECT games.id, games.name, games.released, games.price, games.rating, games.background_image
        FROM game_developer
        JOIN games ON game_developer.game_id = games.id
        WHERE game_developer.developer_id = ?
        LIMIT ? OFFSET ?
    ";

        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("iii", $developer_id, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function get_game_count_by_developer($developer_id)
    {
        $sql = "SELECT COUNT(*) as total FROM game_developer WHERE developer_id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("i", $developer_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? (int) $result['total'] : 0;
    }

}