<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php?page=signin');
    exit;
}
if (($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền truy cập');
}
$error = $_GET['error'] ?? '';
$msg   = $_GET['msg']   ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <base href="/View/admin/">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tạo bài viết mới - BKGame Admin</title>
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-…"
        crossorigin="anonymous" referrerpolicy="no-referrer"/>

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
</head>
<body>
  <div id="app">
    
    <div id="main" style="margin-left: 0">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
      </header>
      <div class="page-heading">
        <div class="page-title row">
          <div class="col-6"><h3>Tạo bài viết mới</h3></div>
          <div class="col-6 text-end">
            <a href="../../index.php?page=kiet_blog_manage" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Quay lại
            </a>
          </div>
        </div>
        <section class="section">
          <div class="card">
            <div class="card-body">
              <?php if ($msg): ?>
                <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
              <?php endif ?>
              <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
              <?php endif ?>

              <form action="/Controller/CreateArticleController.php?action=store"
                    method="POST"
                    enctype="multipart/form-data">
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
      <footer><!-- footer here --></footer>
    </div>
  </div>

  <script src="../assets/static/js/initTheme.js"></script>
  <script src="../assets/static/js/components/dark.js"></script>
  <script src="../assets/compiled/js/app.js"></script>
  <script src="../assets/extensions/jquery/jquery.min.js"></script>
  <script src="../assets/static/js/components/dark.js"></script>
    <!-- <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script> -->
    <script src="../assets/compiled/js/app.js"></script>
    <script src="../assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/static/js/pages/dashboard.js"></script>
    <script src="../assets/extensions/jquery/jquery.min.js"></script>
    <script src="../assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
</body>
</html>
