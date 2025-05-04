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

$jsonData = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/Controller/UsersController.php');
$users = json_decode($jsonData, true);

if (!is_array($users)) {
    echo "Không có bài viết nào để hiển thị.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="/View/admin/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" href="../assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', 'Noto Sans', 'Liberation Sans', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji' !important;
        }

        [data-bs-theme=light] body {
            background-color: #e9fef0 !important;
            border-radius: 10px;
        }

        [data-bs-theme=light] h3,
        [data-bs-theme=light] h5 {
            color: #1d7534 !important;
        }

        [data-bs-theme=dark] body {
            background-color: #0A1F15 !important;
            border-radius: 10px;
        }

        [data-bs-theme=dark] .card,
        [data-bs-theme=dark] .card-header,
        [data-bs-theme=dark] .sidebar-wrapper {
            background-color: #152D24 !important;
            border-radius: 10px;
        }

        [data-bs-theme=dark] select,
        [data-bs-theme=dark] input,
        [data-bs-theme=dark] .paginate_button.page-item a {
            background-color: #0A1F15 !important;
        }

        [data-bs-theme=light] .paginate_button.page-item.active a {
            background-color: green !important;
        }

        [data-bs-theme=dark] .paginate_button.page-item.active a {
            background-color: #81C784 !important;
        }

        [data-bs-theme=light] .paginate_button.page-item.next a:hover,
        [data-bs-theme=light] .paginate_button.page-item.previous a:hover {
            color: green;
        }

        [data-bs-theme=dark] .paginate_button.page-item.next a:hover,
        [data-bs-theme=dark] .paginate_button.page-item.previous a:hover {
            color: green;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let file = "./admin_component/sidebar.html";
            let id = "sidebar";
            fetch(file).then(response => response.text())
            .then(data => {
                document.getElementById(id).innerHTML = data;
                $("li:has(i.fas.fa-user)").addClass("active");
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
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Quản Lý Người Dùng</h3>
                            <p class="text-subtitle text-muted">Quản lý người dùng dành cho quản trị viên.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Người Dùng</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Danh Sách Người Dùng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            <th>Số Điện Thoại</th>
                                            <th>Thành Phố</th>
                                            <th>Vai Trò</th>
                                            <th>Trạng Thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        <?php foreach ($users as $user): ?>
                                            <tr data-id="<?php echo $user['id']; ?>">
                                                <td><?php echo $user['username']?></td>
                                                <td><?php echo $user['email']?></td>
                                                <td><?php echo $user['phone']?></td>
                                                <td><?php echo $user['city']?></td>
                                                <td><?php echo $user['role']?></td>
                                                <td>
                                                    <?php if($user['status'] === "active"):?>
                                                    <span class="badge bg-success">Active</span>
                                                    <?php else:?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                    <?php endif?>
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
                        <p>Được tạo ra bằng <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            bởi <a href="https://saugi.me">Trần Tuấn Kiệt</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="../assets/static/js/components/dark.js"></script>
    <!-- <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script> -->
    <script src="../assets/extensions/jquery/jquery.min.js"></script>
    <script src="../assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/static/js/pages/datatables.js"></script>
    <script src="../assets/compiled/js/app.js"></script>

    <script>
        $(document).ready(function() {
            $("#table1_filter").html(`<label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="table1"></label>`);
            $(".paginate_button.page-item.previous a").text('Trước');
            $(".paginate_button.page-item.next a").text('Sau');
        });
    </script>
</body>
</html>