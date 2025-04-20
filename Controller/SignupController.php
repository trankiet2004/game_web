<?php
require_once('../Model/User.php');
class SignupController {
    public function showSignupPage() {
        include('../View/common_part/signup.html');  // Display signup page
    }

    public function handleSignup() {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Kiểm tra nếu tên người dùng đã tồn tại
        $existingUser = User::findByUsername($username);
        if ($existingUser) {
            echo "Tên người dùng đã tồn tại!";
            return;
        }

        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Lưu người dùng vào cơ sở dữ liệu
        $user = new User($username, $email, $hashedPassword);
        $user->save();

        echo "Đăng ký thành công!";
    }
}
?>