<?php
// Include necessary files
require_once('Controller/GamesController.php');
// require_once('Controller/ArticlesController.php');
// require_once('Controller/AuthController.php');
// require_once('Controller/DevelopersController.php');
// require_once('Controller/FaqsController.php');
// require_once('Controller/GenresController.php');
// require_once('Controller/LoginController.php');
// require_once('Controller/PlatformsController.php');
// require_once('Controller/SignupController.php');
// require_once('Controller/TagsController.php');
// require_once('Controller/UsersController.php');
// Create controller object
$controller = new GamesController();

// Check if the request is for loading products via AJAX
if (isset($_POST['action']) && $_POST['action'] === 'load_products') {
    $controller->load_products();
} else {
    // If not an AJAX request, load the main page
    $controller->index();
}
?>
