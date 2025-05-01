<?php
require_once('../Model/User.php');
class UsersController {
    public static function showUserList() {
        // Lấy toàn bộ user dưới dạng mảng đối tượng
        $users = User::GET('users', null, "id");
        // include view và truyền $users vào
        // include __DIR__.'/../View/admin/user-management.php';
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

UsersController::showUserList();
?>