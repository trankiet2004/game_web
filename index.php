<?php
// Include necessary files
require_once('Controller/GamesController.php');
// Create controller object
$controller = new GamesController();
$page = $_GET['page'] ?? '';

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_products') {
    $controller->load_products();
} else if($page == '') {
    include('./View/thinh/index.php');
} else if($page == 'contact_us') {
    include('./View/thinh/contact_us.php');
} else if($page == 'about_us') {
    include('./View/bao/about_us.php');
} else if($page == 'blogs') {
    include('./View/kiet/blogs.php');
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
    $controller->index();
}
