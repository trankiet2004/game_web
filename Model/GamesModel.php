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

    public function get_game_by_id($id)
    {
        // Get game
        $stmt = $this->connect->prepare("SELECT * FROM games WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $game = $result->fetch_assoc();

        if (!$game) {
            return null;
        }

        // Get tags
        $stmt = $this->connect->prepare("
            SELECT t.* FROM tags t
            JOIN game_tag gt ON t.id = gt.tag_id
            WHERE gt.game_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $tags = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $game['tags'] = $tags;

        // Get genres
        $stmt = $this->connect->prepare("
            SELECT g.* FROM genres g
            JOIN game_genre gg ON g.id = gg.genre_id
            WHERE gg.game_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $genres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $game['genres'] = $genres;

        // Get platforms
        $stmt = $this->connect->prepare("
            SELECT p.* FROM platforms p
            JOIN game_platform gp ON p.id = gp.platform_id
            WHERE gp.game_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $platforms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $game['platforms'] = $platforms;

        // Get screenshots
        $stmt = $this->connect->prepare("
            SELECT * FROM game_screenshots WHERE game_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $screenshots = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $game['screenshots'] = $screenshots;

        // Get developers
        $stmt = $this->connect->prepare("
            SELECT d.* FROM developers d
            JOIN game_developer gd ON d.id = gd.developer_id
            WHERE gd.game_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $developers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $game['developers'] = $developers;

        // Get gameratings
        $stmt = $this->connect->prepare("
            SELECT * FROM gameratings WHERE game_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $ratings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $game['ratings'] = $ratings;

        return $game;
    }

    public function getGameWithTags($gameId)
    {
        try {
            // Get game information
            $stmt = $this->connect->prepare("SELECT * FROM games WHERE id = ?");
            $stmt->bind_param("i", $gameId);
            $stmt->execute();
            $result = $stmt->get_result();
            $game = $result->fetch_assoc();
            $stmt->close();

            if (!$game) {
                return null; // Or return a custom error response
            }

            // Get tags
            $stmt = $this->connect->prepare("
            SELECT t.* FROM tags t
            JOIN game_tag gt ON t.id = gt.tag_id
            WHERE gt.game_id = ?
        ");
            $stmt->bind_param("i", $gameId);
            $stmt->execute();
            $tags = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            $game['tags'] = $tags;

            return $game;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
            return null;
        }
    }

    // Delete tags associated with a game
    public function deleteGameTags($gameId)
    {
        try {
            // Prepare the delete query
            $query = "DELETE FROM game_tag WHERE game_id = ?";
            $stmt = $this->connect->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $this->connect->error);
            }

            // Bind the parameters and execute the query
            $stmt->bind_param("i", $gameId);
            $stmt->execute();

            // Check if the delete was successful
            if ($stmt->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "Tags deleted successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "No tags found for the game."]);
            }

            $stmt->close();
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
        }
    }

    // Add a tag to a game
    public function addGameTag($gameId, $tagName)
    {
        try {
            // First, check if the tag already exists for this game
            $checkQuery = "SELECT * FROM game_tag WHERE game_id = ? AND tag_name = ?";
            $checkStmt = $this->connect->prepare($checkQuery);
            if (!$checkStmt) {
                throw new Exception("Failed to prepare check statement: " . $this->connect->error);
            }

            $checkStmt->bind_param("is", $gameId, $tagName);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                echo json_encode(["success" => false, "message" => "Tag already added to the game."]);
                $checkStmt->close();
                return;
            }

            // Insert the new tag into the game_tag table
            $query = "INSERT INTO game_tag (game_id, tag_name) VALUES (?, ?)";
            $stmt = $this->connect->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare insert statement: " . $this->connect->error);
            }

            $stmt->bind_param("is", $gameId, $tagName);
            $stmt->execute();

            // Check if the insert was successful
            if ($stmt->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "Tag added successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add tag."]);
            }

            $stmt->close();
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
        }
    }
    public function updateGenres($gameId, $selectedGenres)
    {
        try {
            // Delete existing genres for the game
            $stmt = $this->connect->prepare("DELETE FROM game_genre WHERE game_id = ?");
            if (!$stmt) {
                throw new Exception("Error preparing delete statement: " . $this->connect->error);
            }
            $stmt->bind_param("i", $gameId);
            $stmt->execute();
            $stmt->close();

            // Insert the selected genres using INSERT IGNORE to prevent duplicates
            foreach ($selectedGenres as $genreId) {
                $stmt = $this->connect->prepare("INSERT IGNORE INTO game_genre (game_id, genre_id) VALUES (?, ?)");
                if (!$stmt) {
                    throw new Exception("Error preparing insert statement: " . $this->connect->error);
                }
                $stmt->bind_param("ii", $gameId, $genreId);
                $stmt->execute();
                $stmt->close();
            }

            return json_encode(["success" => true, "message" => "Genres updated successfully"]);
        } catch (Exception $e) {
            return json_encode(["error" => $e->getMessage()]);
        }
    }


    // Update tags function
    public function updateTags($gameId, $selectedTags)
    {
        try {
            // Delete existing tags for the game
            $stmt = $this->connect->prepare("DELETE FROM game_tag WHERE game_id = ?");
            if (!$stmt) {
                throw new Exception("Error preparing delete statement: " . $this->connect->error);
            }
            $stmt->bind_param("i", $gameId);
            $stmt->execute();
            $stmt->close();

            // Insert the selected tags with INSERT IGNORE
            foreach ($selectedTags as $tagId) {
                $stmt = $this->connect->prepare("INSERT IGNORE INTO game_tag (game_id, tag_id) VALUES (?, ?)");
                if (!$stmt) {
                    throw new Exception("Error preparing insert statement: " . $this->connect->error);
                }
                $stmt->bind_param("ii", $gameId, $tagId);
                $stmt->execute();
                $stmt->close();
            }

            return json_encode(["success" => true, "message" => "Tags updated successfully"]);
        } catch (Exception $e) {
            return json_encode(["error" => $e->getMessage()]);
        }
    }


    // Update platforms function
    public function updatePlatforms($gameId, $selectedPlatforms)
    {
        try {
            // Delete existing platforms for the game
            $stmt = $this->connect->prepare("DELETE FROM game_platform WHERE game_id = ?");
            if (!$stmt) {
                throw new Exception("Error preparing delete statement: " . $this->connect->error);
            }
            $stmt->bind_param("i", $gameId);
            $stmt->execute();
            $stmt->close();

            // Insert the selected platforms with INSERT IGNORE
            foreach ($selectedPlatforms as $platformId) {
                $stmt = $this->connect->prepare("INSERT IGNORE INTO game_platform (game_id, platform_id) VALUES (?, ?)");
                if (!$stmt) {
                    throw new Exception("Error preparing insert statement: " . $this->connect->error);
                }
                $stmt->bind_param("ii", $gameId, $platformId);
                $stmt->execute();
                $stmt->close();
            }

            return json_encode(["success" => true, "message" => "Platforms updated successfully"]);
        } catch (Exception $e) {
            return json_encode(["error" => $e->getMessage()]);
        }
    }


    // Update developers function
    public function updateDevelopers($gameId, $selectedDevelopers)
    {
        try {
            // Delete existing developers for the game
            $stmt = $this->connect->prepare("DELETE FROM game_developer WHERE game_id = ?");
            if (!$stmt) {
                throw new Exception("Error preparing delete statement: " . $this->connect->error);
            }
            $stmt->bind_param("i", $gameId);
            $stmt->execute();
            $stmt->close();

            // Insert the selected developers with INSERT IGNORE
            foreach ($selectedDevelopers as $developerId) {
                $stmt = $this->connect->prepare("INSERT IGNORE INTO game_developer (game_id, developer_id) VALUES (?, ?)");
                if (!$stmt) {
                    throw new Exception("Error preparing insert statement: " . $this->connect->error);
                }
                $stmt->bind_param("ii", $gameId, $developerId);
                $stmt->execute();
                $stmt->close();
            }

            return json_encode(["success" => true, "message" => "Developers updated successfully"]);
        } catch (Exception $e) {
            return json_encode(["error" => $e->getMessage()]);
        }
    }
    public function deleteScreenshotByPath($path)
    {
        $stmt = $this->connect->prepare("DELETE FROM game_screenshots WHERE img_path = ?");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["error" => "Prepare failed: " . $this->connect->error]);
            return false;
        }

        $stmt->bind_param("s", $path);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function insertScreenshot($gameId, $imgPath)
    {
        $stmt = $this->connect->prepare("INSERT INTO game_screenshots (game_id, img_path) VALUES (?, ?)");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["error" => "Prepare failed: " . $this->connect->error]);
            return false;
        }

        $stmt->bind_param("is", $gameId, $imgPath);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
    public function updateGame($id, $name, $released, $price, $rating, $meta, $description) {
        $sql = "UPDATE games SET name = ?, released = ?, price = ?, rating = ?, metacritic = ?, description = ? WHERE id = ?";
        $stmt = $this->connect->prepare($sql);
        return $stmt->execute([$name, $released, $price, $rating, $meta, $description, $id]);
    }
    
    public function addScreenshot($gameId, $imgPath) {
        $stmt = $this->connect->prepare("INSERT INTO game_screenshots (game_id, img_path) VALUES (?, ?)");
        return $stmt->execute([$gameId, $imgPath]);
    }
    

}


