<?php
session_start();

// 1. Chưa đăng nhập → quay về login
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php?page=signin');
    exit;
}
$role = $_SESSION['user']['role'] ?? null;

// 2. Đã đăng nhập nhưng không phải admin → 403 Forbidden
if ($role !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền truy cập trang này.');
}

$basePath = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($basePath, '/');
$apiUrl = 'http://' . $_SERVER['HTTP_HOST'] . $basePath . '/Controller/ArticlesController.php';
$jsonData = file_get_contents($apiUrl);
$articles = json_decode($jsonData, true);

if (!is_array($articles)) {
    echo "Không có bài viết nào để hiển thị.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="./View/admin/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Các Bài Viết</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        td a {
            font-weight: bold;
        }
        td a:hover {
            text-decoration: underline;
            background-color: green;
            color: white;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let file = "./admin_component/sidebar.html";
            let id = "sidebar";
            fetch(file).then(response => response.text())
            .then(data => {
                document.getElementById(id).innerHTML = data;
                $("li:has(i.fas.fa-pencil-alt)").addClass("active");
                const toggler = document.getElementById("toggle-dark");
                if(!toggler) return;
                const theme = localStorage.getItem("theme");
                toggler.checked = theme === "dark";
                toggler.addEventListener("input", (e) => {
                    if(e.target.checked) {
                        document.body.classList.add("dark");
                        document.documentElement.setAttribute("data-bs-theme", "dark");
                        localStorage.setItem("theme", "dark");
                    } else {
                        document.body.classList.remove("dark");
                        document.documentElement.setAttribute("data-bs-theme", "light");
                        localStorage.setItem("theme", "light");
                    }
                });
            }).catch(error => {
                console.error(`Lỗi khi tải ${file}:`, error);
            });
        });

        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.selectRow');
            checkboxes.forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>
<body>
    <div id="app">
        <div id="sidebar"></div>

        <div id="main">
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Quản Lý Các Bài Viết</h3>
                            <p class="text-subtitle text-muted">Quản lý người dùng dành cho quản trị viên.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Quản Lý Các Bài Viết</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header" style="display: flex; flex-flow: row wrap; justify-content: space-between;">
                            <h5 class="card-title">Quản Lý Các Bài Viết</h5>
                            <a href="../../index.php?page=create_article" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Tạo bài viết mới
                            </a>
                            <a id="deleteSelected" class="btn btn-danger disabled">
                                Xóa Toàn Bộ Các Bài Viết Được Chọn
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"></th>
                                            <th style="width: 40rem;">Tiêu đề bài viết</th>
                                            <th>Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($articles as $article): ?>
                                            <tr data-id="<?php echo $article['id']; ?>">
                                                <td><input type="checkbox" class="selectRow"></td>
                                                <td>
                                                    <a href="../../index.php?page=detail&&id=<?php echo $article['id']; ?>">
                                                        <?php echo htmlspecialchars($article['title']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="edit_article.php?id=<?php echo $article['id']; ?>" class="btn btn-primary">
                                                        Chỉnh Sửa
                                                    </a>
                                                    <a href="delete_article.php?id=<?php echo $article['id']; ?>" class="btn btn-danger">
                                                        Xóa Bài Viết
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 &copy; BKGame</p>
                    </div>
                    <div class="float-end">
                        <p>Được tạo ra bằng <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span> bởi 
                            <a href="https://saugi.me">Trần Tuấn Kiệt</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="../assets/static/js/initTheme.js"></script>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/compiled/js/app.js"></script>
    <script src="../assets/extensions/jquery/jquery.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('.selectRow, #selectAll').on('change', function() {
                ($('.selectRow:checked').length > 0) ? $('#deleteSelected').removeClass('disabled') : $('#deleteSelected').addClass('disabled');
            });
        });

        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.selectRow');
            checkboxes.forEach(cb => cb.checked = source.checked);
        }
    </script>
</body>
</html>
