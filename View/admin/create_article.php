<?php
session_start();

// 1. Chưa đăng nhập → quay về login
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php?page=signin');
    exit;
}
$role = $_SESSION['user']['role'] ?? null;

// 2. Không phải admin → 403 Forbidden
if ($role !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền truy cập trang này.');
}

$error = $_GET['error'] ?? '';
$msg   = $_GET['msg']   ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="./View/admin/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo bài viết mới – BKGame Admin</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', 'Noto Sans', 'Liberation Sans', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji' !important;
        }
        [data-bs-theme=dark] body {
            background-color: #0A1F15 !important;
            border-radius: 10px;
        }
        [data-bs-theme=light] body {
            background-color: #e9fef0 !important;
            border-radius: 10px;
        }
        [data-bs-theme=light] h3,
        [data-bs-theme=light] h4 {
            color: #1d7534 !important;
        }
        [data-bs-theme=dark] .card,
        [data-bs-theme=dark] .card-header,
        [data-bs-theme=dark] .sidebar-wrapper {
            background-color: #152D24 !important;
            border-radius: 10px;
        }
    </style>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("./admin_component/sidebar.html")
            .then(r=>r.text()).then(html=>{
                document.getElementById("sidebar").innerHTML = html;
                document.querySelector("li:has(i.fas.fa-plus-circle)")?.classList.add("active");
                const toggler = document.getElementById("toggle-dark");
                if (!toggler) return;
                toggler.checked = localStorage.getItem("theme")==="dark";
                toggler.addEventListener("input", e=>{
                    document.documentElement.setAttribute(
                        "data-bs-theme",
                        e.target.checked ? "dark" : "light"
                    );
                    localStorage.setItem("theme", e.target.checked ? "dark" : "light");
                });
            })
            .catch(console.error);
    });
    </script>
</head>
<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar"></div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
            </header>
            <div class="page-heading">
                <div class="page-title row">
                    <div class="col-6"><h3>Tạo bài viết mới</h3></div>
                    <div class="col-6 text-end">
                        <a href="kiet_blog_manage.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($msg): ?>
                              <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
                            <?php endif; ?>
                            <?php if ($error): ?>
                              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                            <?php endif; ?>
                            <form action="../../Controller/CreateArticleController.php?action=store" method="POST" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tiêu đề</label>
                                    <input name="title" type="text" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Nội dung</label>
                                    <textarea name="content" rows="6" class="form-control"
                                              placeholder="Ngắt đoạn bằng 2 dòng trống, # Heading1, ## Heading2…" 
                                              required></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Ảnh minh họa (tùy chọn)</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <button class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu bài viết
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start"><p>2025 &copy; BKGame</p></div>
                    <div class="float-end">
                        <p>Được tạo ra bằng <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                           bởi <a href="https://saugi.me">Trần Tuấn Kiệt</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/jquery/jquery.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>
</body>
</html>
