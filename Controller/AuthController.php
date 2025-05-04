<?php
session_start();
require_once __DIR__.'/../Model/User.php';

class AuthController {

    /** Xử lý đăng nhập */
    public function login()
    {
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';

        try {
            $user = User::findByUsername($u);
        } catch (\Throwable $e) {
            $user = null;
        }
        
        if ($user && $user->checkPassword($p)) {
            // $_SESSION['user'] = $user;
            $_SESSION["user"] = [
                "id" => $user->id,
                "username" => $user->username,
                "email" => $user->email,
                "role" => $user->role,
                "phone" => $user->phone ?? null,
                "birthday" => $user->birthday ?? null,
                "gender" => $user->gender ?? null
            ];
            header('Location: '.($user->role==='admin'
                                 ? '../index.php?page=indexAdmin'
                                 : '../index.php?'));
            exit;
        }

        $_SESSION['old'] = ['username'=>$u];
        $_SESSION['err'] = 'Tên đăng nhập hoặc mật khẩu sai!';
        header('Location: ../index.php?page=signin');
    }

    /** Xử lý đăng ký */
    public function signup()
    {
        $email    = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $pass     = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm'] ?? '';

        $_SESSION['old'] = compact('email','username');

        if ($pass!==$confirm){
            $_SESSION['err']='Mật khẩu xác nhận không khớp!';
            header('Location: ../index.php?page=signup'); exit;
        }
        if (User::findByUsername($username)){
            $_SESSION['err']='Tên người dùng đã tồn tại!';
            header('Location: ../index.php?page=signup'); exit;
        }

        $hashed = password_hash($pass,PASSWORD_DEFAULT);
        (new User($username,$email,$hashed,'user',true))->save();

        $_SESSION['msg']='Đăng ký thành công! Vui lòng đăng nhập.';
        header('Location: ../index.php?page=signin');
    }

    /** Hàm tiện tạo admin đầu tiên (chạy 1 lần rồi xoá) */
    public function makeAdmin()
    {
        if (User::findByUsername('admin')) {echo 'Admin đã tồn tại'; return;}
        $hashed = password_hash('admin123',PASSWORD_DEFAULT);
        (new User('admin','admin@example.com',$hashed,'admin',true))->save();
        echo 'Đã tạo tài khoản admin/admin123';
    }
    public function logout() {
        // Hủy session hoàn toàn
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        header('Location: ../index.php?page=signin');
        exit;
    }
}

/* Router siêu gọn */
$action = $_GET['action'] ?? null;
$auth   = new AuthController();
if (method_exists($auth,$action)) $auth->$action();
else die('Action not found');
