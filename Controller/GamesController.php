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
   
    public function updateGenres($gameId, $selectedGenres) {
        
        $this->model->updateGenres($gameId, $selectedGenres);
        // Redirect to the edit page or any page you want after saving
        
        
        header("Location: index.php?page=editGame&id=" . $gameId);
        exit;
    }
    public function updateTags($gameId, $selectedTags) {
        
        $this->model->updateTags($gameId, $selectedTags);
        // Redirect to the edit page or any page you want after saving
        
        
        header("Location: index.php?page=editGame&id=" . $gameId);
        exit;
    }

    public function updatePlatforms($gameId, $selectedPlatforms) {
        
        $this->model->updatePlatforms($gameId, $selectedPlatforms);
        // Redirect to the edit page or any page you want after saving
        
        
        header("Location: index.php?page=editGame&id=" . $gameId);
        exit;
    }

    public function updateDevelopers($gameId, $selectedDevelopers) {
        
        $this->model->updateDevelopers($gameId, $selectedDevelopers);
        // Redirect to the edit page or any page you want after saving
        
        header("Location: index.php?page=editGame&id=" . $gameId);
        exit;
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'load_products') {
    $games = new GamesController();
    $games->load_products();
}

$games = new GamesController();