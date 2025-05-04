<?php
// Include necessary files
require_once('Controller/GamesController.php');
require_once('Controller/PlatformsController.php');
require_once('Controller/GenresController.php');
require_once('Controller/TagsController.php');
require_once('Controller/DevelopersController.php');
// Create controller object
$gamecontroller = new GamesController();
$platformcontroller = new PlatformsController();
$genrescontroller = new GenresController();
$tagcontroller = new TagsController();
$devcontroller = new DevelopersController();

$page = $_GET['page'] ?? '';
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_products') {
    $gamecontroller->load_products();
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_platforms'){
    $platformcontroller->load_platforms();
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_genres'){
    $genrescontroller->load_genres();
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_tags'){
    $tagcontroller->load_tags();
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_developers'){
    $devcontroller->load_developers();
}  else if($action === 'load_more_games'){
    $platformcontroller->load_more_games();
} else if($action === 'load_more_games_in_genres'){
    $genrescontroller->load_more_games();
} else if($action === 'load_more_games_in_tags'){
    $tagcontroller->load_more_games();
} else if($action === 'load_more_games_in_developers'){
    $devcontroller->load_more_games();
} else if($action === 'game' && $id !== null){
    $gamecontroller->get_game_by_id($id);
} else if($action === 'game'){
    $gamecontroller->userindex();
} else if($action === 'platform' && $id !== null){
    $platformcontroller->get_platform_by_id($id);
} else if($action === 'platform'){
    $platformcontroller->index();
}else if($action === 'genres' && $id !== null){
    $genrescontroller->get_genres_by_id($id);
} else if($action === 'genres'){
    $genrescontroller->index();
} else if($action === 'tag' && $id !== null){
    $tagcontroller->get_tag_by_id($id);
} else if($action === 'tag'){
    $tagcontroller->index();
} else if($action === 'developer' && $id !== null){
    $devcontroller->get_developer_by_id($id);
} else if($action === 'developer'){
    $devcontroller->index();
} else if($page == 'tu_game') {
    $gamecontroller->adminindex();
} else if($page == 'contact_us') {
    include('./View/thinh/contact_us.php');
} else if($page == 'about_us') {
    include('./View/bao/about_us.php');
} else if($page == 'blogs') {
    include('./View/kiet/blogs.php');
} else if($page == 'detail') {
    include('./View/kiet/detail.php');
} else if($page == 'forum') {
    include('./View/bao/forum.php');
} else if($page == 'signin') {
    include('./View/common_part/signin.php');
} else if($page == 'signup') {
    include('./View/common_part/signup.php');
} else if($page == 'forgot-password') {
    include('./View/common_part/forgot-password.php');
} else if($page == 'account-profile') {
    include('./View/common_part/account-profile.php');
} else if($page == 'logout') {
    include('./View/common_part/logout.php');
} else if($page == 'comment_manage') {
    include('./View/common_part/comment_manage.php');
} else if($page == 'indexAdmin') {
    include('./View/admin/index.php');
} else if($page == 'bao_comment') {
    include('./View/admin/bao_comment.php');
} else if($page == 'bao_page_manage') {
    include('./View/admin/bao_page_manage.php');
} else if($page == 'bao_edit_page') {
    include('./View/admin/bao_edit_page.php');
} else if($page == 'kiet_blog_manage') {
    include('./View/admin/kiet_blog_manage.php');
} else if($page == 'user-management') {
    include('./View/admin/user-management.php');
} else {
    // Default to the index (product list)
    include('./View/thinh/index.php');
}
