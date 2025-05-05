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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="./View/admin/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Các Trang</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .game-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: black;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .checkbox-label {
            display: inline-block;
            margin-right: 10px;
        }

        .checkbox-input {
            margin-right: 5px;
        }

        .inline-form {
            display: inline-block;
            margin-top: 10px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        textarea {
            background-color: #152D24;
        }

        label{
            color:black !important;
        }

        /* Fix table size and prevent zooming/shrinking */
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let file = "./admin_component/sidebar.html";
            let id = "sidebar";
            fetch(file).then(response => response.text())
                .then(data => {
                    document.getElementById(id).innerHTML = data;
                    $("li:has(i.fas.fa-gamepad)").addClass("active");
                    const toggler = document.getElementById("toggle-dark");
                    if (!toggler) return;
                    const theme = localStorage.getItem("theme");
                    toggler.checked = theme === "dark";
                    toggler.addEventListener("input", (e) => {
                        if (e.target.checked) {
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
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar"></div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Quản Lý Games</h3>
                            <p class="text-subtitle text-muted">Quản lý games dành cho quản trị viên.</p>
                        </div>
                        <div class="col-md-6">
                            <nav class="breadcrumb-header float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../../index.php?page=indexAdmin">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Quản Lý Games</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Danh Sách Games</h5>
                            <a id="add-games" class="btn btn-danger disabled">Thêm game mới</a>
                        </div>

                        <div class="card-body">

                            <!-- Bảng danh sách game -->
                            <div class="table-responsive">
                                <form action="../../index.php?action=addNewGame" method="POST" enctype="multipart/form-data" class="game-form">
                                    <div class="form-group">
                                        <label for="name">Tên Game:</label>
                                        <input type="text" id="name" name="name" required class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="released">Ngày Phát Hành:</label>
                                        <input type="date" id="released" name="released" required class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Mô Tả:</label>
                                        <textarea id="description" name="description" rows="4" required class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="background_image">Ảnh Nền (URL hoặc tải lên):</label>
                                        <input type="file" id="background_image" name="background_image" accept="image/*" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="website">Website:</label>
                                        <input type="url" id="website" name="website" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="updated">Ngày Cập Nhật:</label>
                                        <input type="date" id="updated" name="updated" required class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Giá:</label>
                                        <input type="number" id="price" name="price" min="0" required class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="metacritic">Điểm Metacritic:</label>
                                        <input type="number" id="metacritic" name="metacritic" min="0" max="100" required class="form-control">
                                    </div>

                                    <!-- Thể loại -->
                                    <p><strong>Thể loại:</strong>
                                    <div class="inline-form">
                                        <?php foreach ($allGenre as $genre): ?>
                                            <label class="checkbox-label">
                                                <input type="checkbox" name="genres[]" value="<?= $genre['id'] ?>" class="checkbox-input">
                                                <?= htmlspecialchars($genre['name']) ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    </p>

                                    <!-- Tags -->
                                    <p><strong>Tags:</strong>
                                    <div class="inline-form">
                                        <?php foreach ($allTags as $tag): ?>
                                            <label class="checkbox-label">
                                                <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" class="checkbox-input">
                                                <?= htmlspecialchars($tag['name']) ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    </p>

                                    <!-- Nền tảng -->
                                    <p><strong>Nền tảng:</strong>
                                    <div class="inline-form">
                                        <?php foreach ($allPlatform as $platform): ?>
                                            <label class="checkbox-label">
                                                <input type="checkbox" name="platforms[]" value="<?= $platform['id'] ?>" class="checkbox-input">
                                                <?= htmlspecialchars($platform['name']) ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    </p>

                                    <!-- Nhà phát triển -->
                                    <p><strong>Nhà phát triển:</strong>
                                    <div class="inline-form">
                                        <?php foreach ($allDev as $dev): ?>
                                            <label class="checkbox-label">
                                                <input type="checkbox" name="developers[]" value="<?= $dev['id'] ?>" class="checkbox-input">
                                                <?= htmlspecialchars($dev['name']) ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    </p>

                                    <button type="submit" class="btn btn-primary">Thêm Game</button>
                                </form>

                            </div>
                        </div>
                </section>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>