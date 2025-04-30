<?php
session_start();
// Lấy thông điệp lỗi và dữ liệu cũ, rồi xóa để chỉ hiển thị 1 lần
$err = $_SESSION['err'] ?? null;
$old = $_SESSION['old'] ?? [];
unset($_SESSION['err'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="shortcut icon" href="/game_web/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="icon" type="image/icon" href="/View/img/logo.png">
    <link rel="stylesheet" href="/View/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/View/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="/View/assets/compiled/css/auth.css">
    <style>
        body { font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', 'Noto Sans', Arial, sans-serif !important; }
    </style>
</head>

<body>
    <script src="/View/assets/static/js/initTheme.js"></script>

    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12" style="background-color: #051209 !important;">
                <div id="auth-left">
                    <div class="auth-logo d-flex justify-content-center">
                        <a href="../thinh/index.html"><img src="/View/img/logo.png" class="rounded-circle" style="transform:scale(4.5)" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Đăng Nhập</h1>

                    <!-- Hiển thị lỗi nếu có -->
                    <?php if ($err): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                    <?php endif; ?>

                    <p class="auth-subtitle mb-5">Đăng nhập bằng dữ liệu bạn đã nhập khi đăng ký.</p>

                    <form id="loginForm" action="/Controller/AuthController.php?action=login" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="username" name="username" type="text" class="form-control form-control-xl" placeholder="Username" value="<?= htmlspecialchars($old['username'] ?? '') ?>">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="password" name="password" type="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end mb-4">
                            <input class="form-check-input me-2" type="checkbox" value="" id="keepLogin">
                            <label class="form-check-label text-gray-600" for="keepLogin">Giữ tôi đăng nhập</label>
                        </div>
                        <button class="btn btn-success btn-block btn-lg shadow-lg mt-5 font-bold">Đăng Nhập</button>
                    </form>

                    <p class="text-center my-3">Hoặc</p>
                    <div class="d-flex justify-content-center mb-5">
                        <div class="g-signin2" data-onsuccess="onSignIn" style="transform:scale(1.5)"></div>
                    </div>

                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Bạn chưa có tài khoản? <a href="signup.html" class="font-bold text-success">Đăng Ký</a>.</p>
                        <p><a class="font-bold text-success" href="forgot-password.html">Quên Mật Khẩu?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block bg-secondary" style="background-color: #103c1c !important;"></div>
            </div>></div>
        </div>
    </div>

    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/jquery/jquery.min.js"></script>
    <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
    <script>
        function init(){ gapi.load('auth2',()=>gapi.auth2.init({client_id:'YOUR_CLIENT_ID'})); }
        function onSignIn(googleUser){ var profile=googleUser.getBasicProfile(); console.log(profile.getEmail()); window.location.href='../thinh/index.html'; }
    </script>
</body>
</html>
