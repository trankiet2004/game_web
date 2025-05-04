<?php
require_once(__DIR__ . '/../Model/GenresModel.php');

// $URIPart = explode("/", $_SERVER["REQUEST_URI"]);
// $fetch = new GenresModel();
// $id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
// $fetch->fetch($_SERVER["REQUEST_METHOD"], "genres", $id);

class GenresController
{
    private $model;
    private $limit;

    public function __construct()
    {
        $this->model = new GenresModel();
        $this->limit = 12;
    }

    public function index()
    {
        $title = isset($_POST['title']) ? trim($_POST['title']) : "";
        $sort_option = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'default';
        $sort_by = $sort_option; // pass it to the view

        // Map sort option to database column and order
        $sort = $this->mapSortOption($sort_option);

        // Prepare the filter for the title search
        $filter = [
            "title" => $title
        ];

        // Get the current page, default to 1 if not set
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max(1, $page);  // Ensure page is at least 1

        // Calculate the offset for pagination
        $offset = ($page - 1) * $this->limit;

        // Get platforms based on the filter, sorting, and pagination
        $genres = $this->model->get_genres($sort, $filter, $this->limit, $offset);
        $total = $this->model->get_total_count($filter); // Get total platform count for pagination

        // Calculate the total number of pages
        $totalPages = ceil($total / $this->limit);
        $limit = $this->limit;
        // Include the view to display platforms and pass the data to the view
        require __DIR__ . "/../View/tu/genresList.php";
    }
    public function load_genres()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_genres') {
            // Get title, sort, and pagination info
            $title = $_POST['title'] ?? '';
            $sort_option = $_POST['sort_by'] ?? 'a-z';
            $sort = [
                'order' => $sort_option === 'a-z' ? 'ASC' : 'DESC'
            ];
            $page_num = isset($_POST['page_num']) ? (int) $_POST['page_num'] : 1;
            $page_num = max(1, $page_num);

            $limit = $this->limit;
            $offset = ($page_num - 1) * $limit;

            // Title filter
            $filter = ['title' => $title];

            // Fetch data
            $platforms = $this->model->get_genres($sort, $filter, $limit, $offset);
            $total = $this->model->get_total_count($filter);

            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $platforms,
                'total_pages' => ceil($total / $limit)
            ]);
            exit();
        }
    }

    public function get_genres_by_id($id)
{
    $limit = 5;
    $offset = 0;

    $genres = $this->model->get_genres_by_id($id, $limit, $offset);
    $total_games = $this->model->get_game_count_by_genres($id);

    include('./View/tu/genresDetail.php');
}


    public function load_more_games()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'load_more_games_in_genres') {
        $id = (int) $_POST['id'];
        $page = (int) $_POST['page'];
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $platform_data = $this->model->get_genres_by_id($id, $limit, $offset);
        $games = $platform_data['games'] ?? [];
        $total = $this->model->get_game_count_by_genres($id);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'games' => $games,
            'total' => $total
        ]);
        exit();
    }
}


    private function mapSortOption($sort_option)
    {
        // Map the sort option to actual SQL fields for sorting
        switch ($sort_option) {
            case 'a_z':
                return ['column' => 'name', 'order' => 'ASC'];
            case 'z_a':
                return ['column' => 'name', 'order' => 'DESC'];
            default:
                return ['column' => 'name', 'order' => 'ASC']; // Default sort option
        }
    }
}