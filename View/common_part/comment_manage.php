<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
$userId = $_SESSION['user']['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Quản lý Comment</title>
    <base href="/View/common_part/">
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
            let file = "../component/sidebar.html";
            let id = "sidebar";
            fetch(file).then(response => response.text())
            .then(data => {
                document.getElementById(id).innerHTML = data;
                $("li:has(i.bi.bi-people-fill)").addClass("active");
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
    <div id="app">
        <div id="sidebar"></div>

        <div id="main">
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Quản Lý Các Comment</h3>
                            <p class="text-subtitle text-muted">Quản lý Comment dành cho Comment.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Quản Lý Các Comment</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header" style="display: flex; flex-flow: row wrap; justify-content: space-between;">
                            <h5 class="card-title">Quản Lý Các Comment</h5>
                            <a id="deleteSelected" class="btn btn-danger disabled">
                                Xóa Toàn Bộ Các Comment Được Chọn
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"></th>
                                            <th style="width: 40rem;">Tiêu đề Comment</th>
                                            <th>Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="faq-body"></tbody>
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

    <script src="../assets/static/js/components/dark.js"></script>
    <!-- <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script> -->
    <script src="../assets/compiled/js/app.js"></script>

    <script src="../assets/extensions/jquery/jquery.min.js"></script>
    <script src="../assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
    <script src="../assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
    <script src="../assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
    <script src="../assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="../assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js"></script>
    <script src="../assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
    <script src="../assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
    <script src="../assets/extensions/filepond/filepond.js"></script>
    <script src="../assets/extensions/toastify-js/src/toastify.js"></script>
    <script src="../assets/static/js/pages/filepond.js"></script>

    <script>
        const userId = <?= json_encode($userId) ?>;
        fetch(`../../Controller/FaqsController.php/${userId}`)
        .then(response => response.json())
        .then(data => {
            const body = document.getElementById('faq-body');
            if (!Array.isArray(data) || data.length === 0) {
                body.innerHTML = '<tr><td colspan="3">Không có comment nào.</td></tr>';
                return;
            }

            body.innerHTML = data.map(faq => `
                <tr data-id="${faq.faq_id}">
                    <td><input type="checkbox" class="selectRow"></td>
                    <td>
                        <a href="../kiet/detail.html?id=${faq.faq_id}">
                            ${faq.question}
                        </a>
                    </td>
                    <td>
                        <a href="edit_article.php?id=${faq.faq_id}" class="btn btn-primary">Xem</a>
                        <button class="btn btn-danger delete-btn" data-id="${faq.faq_id}">Xoá Comment</button>
                    </td>
                </tr>
            `).join('');
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu comment:", error);
            document.getElementById('faq-body').innerHTML = '<tr><td colspan="3">Lỗi khi tải dữ liệu.</td></tr>';
        });

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const faqId = this.getAttribute('data-id');
                    if (!confirm("Bạn có chắc chắn muốn xoá comment này?")) return;

                    fetch(`../../Controller/FaqsController.php/${faqId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            this.closest('tr').remove();
                        } else {
                            alert("Không thể xoá comment.");
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi khi xoá:", error);
                        alert("Đã xảy ra lỗi khi xoá comment.");
                    });
                });
            });
        });
    </script>
</body>
</html>