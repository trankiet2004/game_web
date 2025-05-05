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

        /* Fix table size and prevent zooming/shrinking */
        .table-responsive {
            max-height: 700px;
            /* Set a fixed height for the table */
            overflow-y: auto;
            /* Add a vertical scrollbar if content exceeds max height */
        }

        /* Ensure table content does not shrink when the number of rows is small */
        .table {
            table-layout: fixed;
            /* Enable fixed column widths */
            width: 100%;
            /* Ensure table takes up the full width */
        }

        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 5%;
            /* 10% width for the first column (checkbox) */
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 30%;
            /* 30% width for the second column (Game Name) */
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 15%;
            text-align: center;
            /* 20% width for the third column (Release Date) */
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 5%;
            /* 15% width for the fourth column (Price) */
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 10%;
            text-align: center;
            /* 15% width for the fifth column (Rating) */
        }

        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 5%;
            /* 10% width for the sixth column (Actions) */
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 15%;
            text-align: center;
            /* 10% width for the sixth column (Actions) */
        }
        }
    </style>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
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
                            <a id="deleteSelected" class="btn btn-danger disabled">Xoá Các Game Đã Chọn</a>
                        </div>

                        <div class="card-body">
                            <!-- Form tìm kiếm + sắp xếp -->
                            <form id="filter-form" class="mb-3 d-flex gap-3">
                                <input type="text" name="title" placeholder="Tìm theo tên game..."
                                    value="<?= htmlspecialchars($title ?? '') ?>" class="form-control"
                                    style="max-width: 300px;">
                                <select name="sort_by" class="form-select" style="max-width: 200px;">
                                    <option value="default" <?= $sort_by == 'default' ? 'selected' : '' ?>>Mới nhất
                                    </option>
                                    <option value="oldest" <?= $sort_by == 'oldest' ? 'selected' : '' ?>>Cũ nhất</option>
                                    <option value="highest_price" <?= $sort_by == 'highest_price' ? 'selected' : '' ?>>
                                        Giá cao nhất</option>
                                    <option value="lowest_price" <?= $sort_by == 'lowest_price' ? 'selected' : '' ?>>Giá
                                        thấp nhất</option>
                                    <option value="a_z" <?= $sort_by == 'a_z' ? 'selected' : '' ?>>A - Z</option>
                                    <option value="z_a" <?= $sort_by == 'z_a' ? 'selected' : '' ?>>Z - A</option>
                                    <option value="highrating" <?= $sort_by == 'highrating' ? 'selected' : '' ?>> Đánh giá
                                        cao </option>
                                    </option>
                                </select>
                                <button type="button" class="btn btn-success" onclick="fetchGames(1)">Lọc</button>
                                </select>
                            </form>

                            <!-- Bảng danh sách game -->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                                            </th>
                                            <th>Tên Game</th>
                                            <th>Ngày Phát Hành</th>
                                            <th>Giá</th>
                                            <th>Đánh Giá</th>
                                            <th>Meta</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="games-table-body">
                                        <?php if (!empty($game)): ?>
                                            <?php foreach ($game as $g): ?>
                                                <tr>
                                                    <td><input type="checkbox" class="selectRow" name="selected[]"
                                                            value="<?= $g['id'] ?>"></td>
                                                    <td><?= htmlspecialchars($g['name']) ?></td>
                                                    <td><?= htmlspecialchars($g['released']) ?></td>
                                                    <td><?= $g['price'] ?> </td>
                                                    <td><?= $g['rating'] ?></td>
                                                    <td><?= $g['metacritic'] ?></td>
                                                    <td>
                                                    <a href="../../index.php?page=editGame&id=<?= $g['id'] ?>" class="btn btn-sm btn-danger" ">Xem chi tiết</a>
                                

                                                        <a href="../../index.php?page=deleteGame&id=<?= $g['id'] ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Xác nhận xoá game này?')">Xoá</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7">Không tìm thấy game nào.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>


                            </div>

                            <p class="mt-3">Tổng số game: <?= $total ?? 0 ?></p>
                        </div>
                    </div>
                    <div id="pagination-container" class="mt-3 text-center"></div>
                </section>
            </div>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        let currentPage = 1;

        function fetchGames(page = 1) {
            const title = $("input[name='title']").val();
            const sort_by = $("select[name='sort_by']").val();

            $.post("../../index.php?action=load_products", {
                action: "load_products",
                title: title,
                sort_by: sort_by,
                page_num: page
            }, function (res) {
                if (res.status === "success") {
                    const games = res.data;
                    const totalPages = res.total_pages;
                    currentPage = page;

                    let rowsHtml = "";
                    for (let game of games) {
                        rowsHtml += `
                    <tr>
                        <td><input type="checkbox" class="selectRow" value="${game.id}"></td>
                        <td>${game.name}</td>
                        <td>${game.released}</td>
                        <td>${game.price}</td>
                        <td>${game.rating}</td>
                        <td>${game.metacritic}</td>
                        <td>
                             <a href="../../index.php?page=editGame&id=${game.id}" class="btn btn-sm btn-primary" ">Xem chi tiết</a>
                            <a href="../../index.php?page=deleteGame&id=${game.id}" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xoá game này?')">Xoá</a>
                        </td>
                    </tr>`;
                    }

                    $("#games-table-body").html(rowsHtml);
                    renderPagination(totalPages, page); // Render pagination
                }
            }, 'json');
        }

        function renderPagination(totalPages, currentPage) {
            let html = "";
            for (let i = 1; i <= totalPages; i++) {
                html += `<button class="btn ${i === currentPage ? 'btn-primary' : 'btn-light'} m-1" onclick="fetchGames(${i})">${i}</button>`;
            }
            $("#pagination-container").html(html);
        }

        // Load first page on page load
        $(document).ready(function () {
            fetchGames(1);  // Trigger the first page load
        });

        // Handle filter form submit
        $("#filter-form").on("submit", function (e) {
            e.preventDefault();  // Prevent the form from submitting normally
            fetchGames(1);  // Reset to page 1 and fetch the filtered games
        });
    
            
        
    




    </script>
</body>