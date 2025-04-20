<?php
require_once('../Model/User.php');
class UserManagementController {
    public function showUserList() {
        // Fetch users from database
        $users = User::getAllUsers();
        include('views/user-management.html');
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
?>