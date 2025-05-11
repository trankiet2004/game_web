<?php
session_start();
// bảo vệ route
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php?page=signin');
    exit;
}
if (($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền truy cập.');
}

require_once __DIR__ . '/../../Model/DBConnect.php';

// lấy article
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('ID bài viết không hợp lệ.');
}
$stmt = $connect->prepare("SELECT * FROM articles WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$article = $stmt->get_result()->fetch_assoc() ?: null;
$stmt->close();
if (!$article) {
    die('Không tìm thấy bài viết.');
}

// lấy comments
$cm = $connect->prepare("SELECT * FROM blog_comment WHERE article_id=? ORDER BY created_at DESC");
$cm->bind_param('i', $id);
$cm->execute();
$comments = $cm->get_result()->fetch_all(MYSQLI_ASSOC);
$cm->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <base href="./View/admin/">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chỉnh sửa bài viết #<?= $id ?></title>
  <link rel="icon" type="image/icon" href="../img/logo.png">
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/iconly.css">
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
    </style>
</head>
<body>
  <div id="app">
    
    <div id="main" style="margin-left: 0;">
      <!-- <header class="mb-3">…</header> -->

      <div class="page-heading">
        <h3>Chỉnh sửa bài viết</h3>
        <a href="../../index.php?page=kiet_blog_manage" class="btn btn-secondary mb-3">
          <i class="fas fa-arrow-left"></i> Quay lại
        </a>

        <section class="section">
          <div class="card">
            <div class="card-body">
              <form action="/Controller/EditArticleController.php?action=update&id=<?= $id ?>"
                    method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                  <label class="form-label">Tiêu đề</label>
                  <input name="title" type="text" required
                         class="form-control"
                         value="<?= htmlspecialchars($article['title']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <?php
                        function convertHtmlToPlainText($html) {
                            $text = $html;

                            // Chuyển tiêu đề
                            $text = preg_replace('/<h1[^>]*>(.*?)<\/h1>/i', "# $1\n\n", $text);
                            $text = preg_replace('/<h2[^>]*>(.*?)<\/h2>/i', "## $1\n\n", $text);
                            $text = preg_replace('/<h3[^>]*>(.*?)<\/h3>/i', "### $1\n\n", $text);

                            // Chuyển đoạn văn và xuống dòng
                            $text = preg_replace('/<p[^>]*>(.*?)<\/p>/i', "$1\n\n", $text);
                            $text = preg_replace('/<br\s*\/?>/i', "\n", $text);

                            // Loại bỏ các thẻ còn sót lại
                            $text = strip_tags($text);

                            // Trim và chuẩn hóa khoảng trắng
                            return trim($text);
                        }

                        $plainContent = htmlspecialchars(convertHtmlToPlainText($article['content']));
                        ?>
                    <textarea name="content" rows="8" required class="form-control"><?= $plainContent ?></textarea>
                  <small class="text-muted">Dùng 2 dòng trống để ngắt đoạn, # Heading1, ## Heading2…</small>
                </div>

                <div class="mb-3">
                  <label class="form-label">Ảnh hiện tại</label><br>
                  <?php if ($article['image']): ?>
                    <img src="../img/blogsImg/<?= basename($article['image']) ?>"
                         class="img-thumbnail mb-2" style="max-width:200px;"><br>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remove_image" id="rmimg">
                      <label class="form-check-label" for="rmimg">
                        Xóa ảnh hiện tại
                      </label>
                    </div>
                  <?php else: ?>
                    <p class="text-muted">Chưa có ảnh minh họa.</p>
                  <?php endif; ?>
                </div>

                <div class="mb-3">
                  <label class="form-label">Đổi/tải lên ảnh mới</label>
                  <input type="file" name="image" accept="image/*" class="form-control">
                </div>

                <button class="btn btn-primary">
                  <i class="fas fa-save"></i> Lưu thay đổi
                </button>
              </form>
            </div>
          </div>
        </section>

        <!-- Comments -->
        <h4 class="mt-4">Bình luận (<?= count($comments) ?>)</h4>
        <?php if (!$comments): ?>
          <p class="text-muted">Chưa có bình luận.</p>
        <?php else: ?>
          <?php foreach ($comments as $c): ?>
            <div class="card mb-2 p-2">
              <div class="d-flex justify-content-between">
                <span><strong><?= htmlspecialchars($c['user_name']) ?></strong>
                      &bull; <?= date('Y-m-d H:i', strtotime($c['created_at'])) ?></span>
                <a href="/Controller/EditArticleController.php?action=delete_comment&id=<?= $c['id'] ?>&article_id=<?= $id ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Xóa bình luận này?')">
                  <i class="fas fa-trash"></i>
                </a>
              </div>
              <p class="mb-0"><?= nl2br(htmlspecialchars($c['content'])) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div> <!-- /.page-heading -->
    </div>
  </div>
  
  <script src="../assets/static/js/components/dark.js"></script>
    <!-- <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script> -->
    <script src="../assets/compiled/js/app.js"></script>
    <script src="../assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/static/js/pages/dashboard.js"></script>
    <script src="../assets/extensions/jquery/jquery.min.js"></script>
    <script src="../assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
</body>
</html>
