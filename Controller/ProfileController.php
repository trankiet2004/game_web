<?php
session_start();
require_once __DIR__.'/../Model/DBConnect.php';

class ProfileController {
    public function uploadAvatar() {
        if (!isset($_SESSION['user'])) {
            header('Location: /View/common_part/signin.php');
            exit;
        }
        $id = (int)$_SESSION['user']['id'];

        if (empty($_FILES['avatar']['tmp_name'])) {
            die('Chưa chọn ảnh.');
        }
        // Đọc file nhị phân và MIME
        $data = file_get_contents($_FILES['avatar']['tmp_name']);
        $mime = mime_content_type($_FILES['avatar']['tmp_name']);

        // Cập nhật BLOB vào DB
        global $connect;
        $sql = $connect->prepare("
            UPDATE users 
               SET avatar = ?, avatar_type = ?
             WHERE id = ?
        ");
        // bind_param không trực tiếp bind blob, cần send_long_data
        $sql->bind_param('bsi', $null, $mime, $id);
        $sql->send_long_data(0, $data);
        if (!$sql->execute()) {
            die('Lỗi lưu ảnh: ' . $sql->error);
        }
        $sql->close();

        // Cập nhật session (nếu cần)
        $_SESSION['user']['avatar_type'] = $mime;

        header('Location: /View/common_part/account-profile.php');
        exit;
    }
}

/* Router đơn giản */
$action = $_GET['action'] ?? '';
$ctrl = new ProfileController();
if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    http_response_code(404);
    echo 'Action không tồn tại';
}
