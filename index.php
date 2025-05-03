<?php
// Include necessary files
require_once('Controller/GamesController.php');
spl_autoload_register(function ($class) {
    $file = __DIR__ . "/Controller/{$class}.php";
    if (file_exists($file)) require_once $file;
});
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
$page = $_GET['page'] ?? '';

// Check if the request is for loading products via AJAX
if (isset($_POST['action']) && $_POST['action'] === 'load_products') {
    $controller->load_products();
} else if($page == '') {
    (new ThinhController())->index();
} else if($page == 'tu') {
    (new TuController())->index();
} else if($page == 'kiet') {
    (new KietController())->index();
} else if($page == 'bao') {
    (new BaoController())->index();
} else {
    // If not an AJAX request, load the main page
    $controller->index();
}
?>
