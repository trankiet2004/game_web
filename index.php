<?php
// Include necessary files
require_once('Controller/GamesController.php');

// Create controller object
$controller = new GamesController();

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_products') {
    $controller->load_products();
    exit();
}

// Handle URL-based actions
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if ($action === 'game' && $id !== null) {
    $controller->get_game_by_id($id);
} else {
    // Default to the index (product list)
    $controller->index();
}
