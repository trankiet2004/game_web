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
  <title>Tạo bài viết mới – BKGame Admin</title>
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-…"
        crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
  <div id="app">
    <div id="sidebar"><!-- load sidebar via JS --></div>
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
  <script>
    // load sidebar/footer nếu cần
  </script>
</body>
</html>
