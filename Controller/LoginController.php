<?php
require_once('../Model/User.php');
class LoginController {
    public function showLoginPage() {
        include('views/signin.html');  // Display login page
    }

    public function handleLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Tìm người dùng từ cơ sở dữ liệu
        $user = User::findByUsername($username);

        if ($user && $user->checkPassword($password)) {
            $_SESSION['user'] = $user;
            if ($user->role == 'admin') {
                header('Location: admin-dashboard.php');
            } else {
                header('Location: user-dashboard.php');
            }
        } else {
            echo "Thông tin đăng nhập không hợp lệ!";
        }
    }

}
?>