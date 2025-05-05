<?php
require_once(__DIR__ . '/../Model/GamesModel.php');
require_once(__DIR__ . '/../Model/TagsModel.php');
require_once(__DIR__ . '/../Model/PlatformsModel.php');
require_once(__DIR__ . '/../Model/GenresModel.php');
require_once(__DIR__ . '/../Model/DeveloperModel.php');
// $URIPart = explode("/", $_SERVER["REQUEST_URI"]);
// $fetch = new GamesModel();
// $id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
// $fetch->fetch($_SERVER["REQUEST_METHOD"], "games", $id);

class GamesController
{
    private $model;
    private $limit;

    public function __construct()
    {
        $this->model = new GamesModel();
        $this->limit = 12; // Set the number of products per page
    }

    // Display the product list with form-based filtering and sorting


    public function userindex()
    {
        // Get the title and sort options from the POST request
        $title = isset($_POST['title']) ? trim($_POST['title']) : "";
        $sort_option = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'default';
        $sort_by = $sort_option; // pass it to the view


        // Map sort option to database column and order
        $sort = $this->mapSortOption($sort_option);

        // Prepare the filter for the title search
        $filter = [
            "title" => $title
        ];

        // Get products based on the filter, sorting, and pagination
        $game = $this->model->get_products($sort, $filter, $this->limit, 0);
        $total = $this->model->get_total_count($filter); // Get total products count for pagination
        $limit = $this->limit;
        // $sort_by = $sort;
        // Include the view to display products and pass the data to the view\
        require __DIR__ . "/../View/tu/gameList.php";
    }

    public function adminindex()
    {
        // Get the title and sort options from the POST request
        $title = isset($_POST['title']) ? trim($_POST['title']) : "";
        $sort_option = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'default';
        $sort_by = $sort_option; // pass it to the view


        // Map sort option to database column and order
        $sort = $this->mapSortOption($sort_option);

        // Prepare the filter for the title search
        $filter = [
            "title" => $title
        ];

        // Get products based on the filter, sorting, and pagination
        $game = $this->model->get_products($sort, $filter, $this->limit, 0);
        $total = $this->model->get_total_count($filter); // Get total products count for pagination
        $limit = $this->limit;
        // $sort_by = $sort;
        // Include the view to display products and pass the data to the view\
        require __DIR__ . "/../View/admin/tu-game.php";
    }



    // Handle the AJAX request for loading more products
    public function load_products()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'load_products') {
            // Get the title, sort option, and page number from the POST request
            $title = $_POST['title'] ?? '';
            $sort = $this->mapSortOption($_POST['sort_by'] ?? 'default');

            $page_num = $_POST['page_num'] ?? 1;
            $limit = $this->limit;
            $offset = ($page_num - 1) * $limit;

            // Prepare the filter for the title search
            $filter = [
                'title' => $title
            ];

            // Get products from the model
            $products = $this->model->get_products($sort, $filter, $limit, $offset);
            $total = $this->model->get_total_count($filter);

            // Return the response as JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $products,
                'total_pages' => ceil($total / $limit)
            ]);
            exit();
        }
    }

    public function get_game_by_id($id)
    {
        $game = $this->model->get_game_by_id($id);
        if ($game) {
            require __DIR__ . "/../View/tu/gameDetail.php"; // Make sure you have this view
        } else {
            echo "Game not found";
        }
    }



    public function editGame($id)
    {
        $game = $this->model->get_game_by_id($id);
        $tagmodel = new TagsModel();
        $devmodel = new DevelopersModel();
        $genremodel = new GenresModel();
        $platformmodel = new PlatformsModel();
        $allTags = $tagmodel->getAllTags();
        $allDev = $devmodel->getAllDev();
        $allGenre = $genremodel->getAllGenre();
        $allPlatform = $platformmodel->getAllPlatform();
        if ($game) {
            require __DIR__ . "/../View/admin/tu_edit_game.php"; // Make sure you have this view
        } else {
            echo "Game not found";
        }
    }
    // Map the sort option to database columns and order
    private function mapSortOption($sort_option)
    {
        switch ($sort_option) {
            case 'oldest':
                return ["by" => "released", "order" => "ASC"];
            case 'highest_price':
                return ["by" => "price", "order" => "DESC"];
            case 'lowest_price':
                return ["by" => "price", "order" => "ASC"];
            case 'a_z':
                return ["by" => "slug", "order" => "ASC"];
            case 'z_a':
                return ["by" => "slug", "order" => "DESC"];
            case 'highrating':
                return ["by" => "rating", "order" => "DESC"];
            default:
                return ["by" => "released", "order" => "DESC"]; // Default sort option
        }
    }

    public function updateGenres($gameId, $selectedGenres)
    {

        $this->model->updateGenres($gameId, $selectedGenres);
        // Redirect to the edit page or any page you want after saving


        header("Location: index.php?page=editGame&id=" . $gameId);
        exit;
    }
    public function updateTags($gameId, $selectedTags)
    {

        $this->model->updateTags($gameId, $selectedTags);
        // Redirect to the edit page or any page you want after saving


        header("Location: index.php?page=editGame&id=" . $gameId);
        exit;
    }

    public function updatePlatforms($gameId, $selectedPlatforms)
    {

        $this->model->updatePlatforms($gameId, $selectedPlatforms);
        // Redirect to the edit page or any page you want after saving


        header("Location: index.php?page=editGame&id=" . $gameId);
        exit;
    }

    public function updateDevelopers($gameId, $selectedDevelopers)
    {

        $this->model->updateDevelopers($gameId, $selectedDevelopers);
        // Redirect to the edit page or any page you want after saving

        header("Location: index.php?page=editGame&id=" . $gameId);
        exit;
    }
    public function deleteScreenshot($imgPath)
    {
        if ($imgPath) {
            $fullPath = __DIR__ . '../View/data/' . $imgPath;
            // Remove from DB
            $this->model->deleteScreenshotByPath($imgPath);

            // Remove file
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No path']);
        }
    }

    public function saveEditedGame($data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $released = $data['released'];
        $price = $data['price'];
        $rating = $data['rating'];
        $meta = $data['meta'];
        $description = $data['description'];

        $success = $this->model->updateGame($id, $name, $released, $price, $rating, $meta, $description);

        echo json_encode(['success' => $success]);
    }

    public function uploadScreenshot($post, $files)
    {
        $gameId = $post['game_id'] ?? null;

        if (!$gameId || !isset($files['screenshot'])) {
            echo json_encode(['success' => false, 'message' => 'Missing game ID or file.']);
            return;
        }

        $file = $files['screenshot'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'File upload error.']);
            return;
        }

        $uploadDir = __DIR__ . '/../View/data/img/screenshots/';
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uniqueNumber = uniqid();
        $filename = "{$gameId}_screenshot_{$uniqueNumber}.{$extension}";
        $targetPath = $uploadDir . $filename;
        $relativePath = 'img/screenshots/' . $filename; // for DB (img_path)

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
            return;
        }

        // Insert to DB
        if ($this->model->addScreenshot($gameId, $relativePath)) {
            echo json_encode(['success' => true, 'img_path' => $relativePath]);
        } else {
            echo json_encode(['success' => false, 'message' => 'DB insert failed.']);
        }
    }
    public function addGame()
    {
        $tagmodel = new TagsModel();
        $devmodel = new DevelopersModel();
        $genremodel = new GenresModel();
        $platformmodel = new PlatformsModel();
        $allTags = $tagmodel->getAllTags();
        $allDev = $devmodel->getAllDev();
        $allGenre = $genremodel->getAllGenre();
        $allPlatform = $platformmodel->getAllPlatform();
        require __DIR__ . "/../View/admin/tu_add_game.php"; // Make sure you have this view

    }
    private function uploadImage($inputName)
    {
        $uploadDir =  __DIR__ . '/../View/data/img/games/';
        $fileName = '';

        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $fileTmpPath = $_FILES[$inputName]['tmp_name'];
            $fileName =  'game' . time() . '.jpg'; // Format the file name as game{id}.jpg

            // Move the file to the desired directory
            if (move_uploaded_file($fileTmpPath, $uploadDir . $fileName)) {
                return "img/games/" . $fileName;
            }
        }

        // Return default if no file is uploaded
        return '';
    }


    public function addNewGame($post)
    {
        // Get the next game ID for image naming
        $nextGameId = $this->model->getNextGameId();

        // Upload image with game ID in filename
        $background_image = $this->uploadImage('background_image', $nextGameId);

        // Collect POST data
        $name = $_POST['name'] ?? '';
        $released = $_POST['released'] ?? '';
        $description = $_POST['description'] ?? '';
        $website = $_POST['website'] ?? '';
        $updated = $_POST['updated'] ?? '';
        $price = $_POST['price'] ?? 0;
        $metacritic = $_POST['metacritic'] ?? 0;

        $genres = $_POST['genres'] ?? [];
        $tags = $_POST['tags'] ?? [];
        $platforms = $_POST['platforms'] ?? [];
        $developers = $_POST['developers'] ?? [];

        // Insert game using the known ID and background image
        $gameId = $this->model->addGame($nextGameId, $name, $released, $description, $background_image, $website, $updated, $price, $metacritic);

        // Insert into relation tables
        $this->model->insertGameRelations($gameId, $genres, $tags, $platforms, $developers);

        header("Location: index.php?page=tu_game");
        exit;
    }
    public function deleteGame($id) {
        $res = $this->model->delete($id);
        header("ContentType: application/json");
        echo json_encode($res);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'load_products') {
    $games = new GamesController();
    $games->load_products();
}

$games = new GamesController();
