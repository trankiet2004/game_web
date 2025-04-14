<?php
class FetchController {
    private $connect;

    public function __construct($connect) {
        $this->connect = $connect;
    }

    public function GET($table, $id, $idColumn) {
        header("Content-type: application/json");

        try {
            $SQL = !$id ? "SELECT * FROM $table" : "SELECT * FROM $table WHERE $idColumn = $id";
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

    public function fetch($method, $table, $id, $idColumn = "id") {
        switch ($method) {
            case "GET":
                $this->GET($table, $id, $idColumn);
                break;
        }
    }
}