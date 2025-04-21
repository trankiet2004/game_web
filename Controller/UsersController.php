<?php
require_once('../Model/User.php');
class UsersController {
    public function showUserList() {
        // Fetch users from database
        $URIPart = explode("/", $_SERVER["REQUEST_URI"]);
        $id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
        UsersModel::GET("users", $id, "id");
    }

    public function changeUserRole($userId, $newRole) {
        // Tìm người dùng từ cơ sở dữ liệu
        $user = User::findById($userId);
        if ($user) {
            $user->role = $newRole;
            $user->save();  // Lưu vai trò mới vào cơ sở dữ liệu
            echo "Cập nhật vai trò thành công!";
        } else {
            echo "Không tìm thấy người dùng.";
        }
    }
}

if($_SERVER["REQUEST_METHOD"] === "GET") {
    $userController = new UsersController();
    $userController->showUserList();
}
?>