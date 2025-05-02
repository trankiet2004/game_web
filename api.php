<?php
require_once('Controller/GamesController.php');

// Enable CORS for cross-origin requests
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json");

$uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

if (strpos($uri, '/api/games') !== false) {
    $controller = new GamesController();

    // Handle API Routes
    if ($request_method == 'GET') {
        if (isset($_GET['id'])) {
            // Single game by ID
            $controller->get_game_by_id($_GET['id']);
        } else {
            // All games
            $controller->index();
        }
    } elseif ($request_method == 'POST') {
        $controller->create_game();
    } elseif ($request_method == 'PUT') {
        $controller->update_game();
    } elseif ($request_method == 'DELETE') {
        $controller->delete_game($_GET['id']);
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(["error" => "Method not allowed"]);
    }
}
