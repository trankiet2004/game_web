<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Tài Khoản</title>    
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="../assets/extensions/filepond/filepond.css">
    <link rel="stylesheet" href="../assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
    <link rel="stylesheet" href="../assets/extensions/toastify-js/src/toastify.css">
    
    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', 'Noto Sans', 'Liberation Sans', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji' !important;
        }

        [data-bs-theme=dark] body {
            background-color: #0A1F15 !important;
            border-radius: 10px;
        }

        [data-bs-theme=dark] .card-body,
        [data-bs-theme=dark] .card-header,
        [data-bs-theme=dark] .sidebar-wrapper {
            background-color: #152D24 !important;
            border-radius: 10px;
        }

        [data-bs-theme=dark] input, 
        [data-bs-theme=dark] select {
            background-color: #1E3529 !important;
        }

        [data-bs-theme=light] body {
            background-color: #e9fef0 !important;
            border-radius: 10px;
        }

        [data-bs-theme=light] .card-body {
            background-color: white !important;
            border-radius: 10px;
        }

        [data-bs-theme=light] input, 
        [data-bs-theme=light] select {
            background-color: white !important;
        }

        [data-bs-theme=light] h3 {
            color: #1d7534 !important;
        }
    </style>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let file = "../component/sidebar.html";
            let id = "sidebar";
            fetch(file).then(response => response.text())
            .then(data => {
                document.getElementById(id).innerHTML = data;
                $("li:has(i.bi.bi-person-circle)").addClass("active");
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
                            <h3>Hồ Sơ Tài Khoản</h3>
                            <p class="text-subtitle text-muted">Một trang nơi người dùng có thể thay đổi thông tin hồ sơ</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../thinh/index.html">Trang Chủ</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Hồ Sơ</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center flex-column">
                                        <div class="avatar avatar-2xl">
                                            <img src="../img/avatar/chu_tich_hoi_dong_quan_tri.jpg" alt="Avatar">
                                        </div>

                                        <h3 class="mt-3">Trần Tuấn Kiệt</h3>
                                        <p class="text-small">Kỹ sư phần mềm cao cấp</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Upload Avatar Cá Nhân</h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body" style="border-radius: 0 0 10px 10px;">
                                        <p class="card-text">
                                            Các định dạng được cho phép JPG, JPEG, PNG. Kích thước ảnh không được vượt quá 300KB.
                                        </p>
                                        <input type="file" class="basic-filepond">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="#" method="get">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Tên</label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Tên Của Bạn" value="Trần Tuấn Kiệt">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Email Của Bạn" value="kiet.trantuan2004@hcmut.edu.vn">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Số Điện Thoại</label>
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Số Điện Thoại Của Bạn" value="0707040551">
                                        </div>
                                        <div class="form-group">
                                            <label for="birthday" class="form-label">Ngày Sinh</label>
                                            <input type="date" name="birthday" id="birthday" class="form-control" placeholder="Ngày Sinh Của Bạn" value="2004-11-11">
                                        </div>
                                        <div class="form-group">
                                            <label for="gender" class="form-label">Giới Tính</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="male">Nam</option>
                                                <option value="female">Nữ</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                                        </div>
                                    </form>
                                </div>
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
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
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
        $(document).ready(function() {
            $(".filepond--drop-label label").html(`Kéo thả files của bạn hoặc <span class="filepond--label-action" tabindex="0">Duyệt</span>`);
        });
    </script>
</body>
</html>