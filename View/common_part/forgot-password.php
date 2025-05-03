<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="/View/common_part/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <link rel="shortcut icon" href="../assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" href="../assets/compiled/css/app.css">
    <link rel="stylesheet" href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="../assets/compiled/css/auth.css">
    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', 'Noto Sans', 'Liberation Sans', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji' !important;
        }
    </style>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>

    <div id="auth">        
        <div class="row h-100">
            <div class="col-lg-5 col-12" style="background-color: #051209 !important;">
                <div id="auth-left">
                    <div class="auth-logo" style="display: flex; flex-flow: row wrap; justify-content: center;">
                        <a href="../thinh/index.html"><img src="../img/logo.png" style="transform: scale(4.5); border-radius: 999px;" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Quên Mật Khẩu</h1>
                    <p class="auth-subtitle mb-5">Nhập email của bạn và chúng tôi sẽ gửi cho bạn liên kết đặt lại mật khẩu.</p>

                    <form action="../thinh/index.html">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button class="btn btn-success btn-block btn-lg shadow-lg mt-5 font-bold">Gửi</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Ghi nhớ tài khoản của bạn? <a href="signin.php" class="font-bold text-success">Đăng nhập</a>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block" style="background-color: #103c1c !important;"></div>
        </div>
    </div>
</body>

</html>