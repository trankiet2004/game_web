<?php
// Include necessary files
require_once('Controller/GamesController.php');
require_once('Controller/PlatformsController.php');
require_once('Controller/GenresController.php');
require_once('Controller/TagsController.php');
require_once('Controller/DevelopersController.php');

// Create controller objects
$controllers = [
    'game' => new GamesController(),
    'platform' => new PlatformsController(),
    'genre' => new GenresController(),
    'tag' => new TagsController(),
    'developer' => new DevelopersController()
];

$page = $_GET['page'] ?? '';
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

// Helper function to include views
function includeView($viewPath) {
    include($viewPath);
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $postActions = [
        'load_products' => 'load_products',
        'load_platforms' => 'load_platforms',
        'load_genres' => 'load_genres',
        'load_tags' => 'load_tags',
        'load_developers' => 'load_developers',
        'load_more_games' => 'load_more_games',
        'load_more_games_in_genres' => 'load_more_games',
        'load_more_games_in_tags' => 'load_more_games',
        'load_more_games_in_developers' => 'load_more_games'
    ];

    $action = $_POST['action'];
    if (isset($postActions[$action])) {
        $controllerKey = explode('_', $action)[1];  // e.g., 'platform' from 'load_platforms'
        if (isset($controllers[$controllerKey])) {
            $controllers[$controllerKey]->{$postActions[$action]}();
        }
        exit; // End the script after processing the AJAX request
    }
}

// Route actions to appropriate controllers
if ($action && $id !== null) {
    $actionMap = [
        'game' => 'get_game_by_id',
        'platform' => 'get_platform_by_id',
        'genres' => 'get_genres_by_id',
        'tag' => 'get_tag_by_id',
        'developer' => 'get_developer_by_id'
    ];

    if (array_key_exists($action, $actionMap)) {
        $controllers[$action]->{$actionMap[$action]}($id);
    }
} elseif ($action) {
    // Default action is to show the index page for each controller
    $indexActions = [
        'game' => 'index',
        'platform' => 'index',
        'genres' => 'index',
        'tag' => 'index',
        'developer' => 'index'
    ];

    if (array_key_exists($action, $indexActions)) {
        $controllers[$action]->{$indexActions[$action]}();
    }
} else {
    // Page Routing
    $pageViews = [
        'tu_game' => './View/admin/bao_comment.php',
        'contact_us' => './View/thinh/contact_us.php',
        'about_us' => './View/bao/about_us.php',
        'blogs' => './View/kiet/blogs.php',
        'detail' => './View/kiet/detail.php',
        'forum' => './View/bao/forum.php',
        'signin' => './View/common_part/signin.php',
        'signup' => './View/common_part/signup.php',
        'forgot-password' => './View/common_part/forgot-password.php',
        'account-profile' => './View/common_part/account-profile.php',
        'logout' => './View/common_part/logout.php',
        'comment_manage' => './View/common_part/comment_manage.php',
        'indexAdmin' => './View/admin/index.php',
        'bao_comment' => './View/admin/bao_comment.php',
        'bao_page_manage' => './View/admin/bao_page_manage.php',
        'bao_edit_page' => './View/admin/bao_edit_page.php',
        'kiet_blog_manage' => './View/admin/kiet_blog_manage.php',
        'user-management' => './View/admin/user-management.php'
    ];

    if (isset($pageViews[$page])) {
        includeView($pageViews[$page]);
    } else {
        // Default view for unknown pages
        includeView('./View/thinh/index.php');
    }
}
?>
