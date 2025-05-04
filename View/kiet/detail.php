<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <base href="./View/kiet/">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BKGame - Chi Tiết Bài Viết</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="detail.css">
  <script>
    const currentUser = <?= isset($_SESSION['user']) ? json_encode([
      'id' => $_SESSION['user']['id'],
      'username' => $_SESSION['user']['username']
    ]) : 'null' ?>;
  </script>
</head>
<body class="text-light">
  <div id="header" data-scroll></div>

  <main class="container my-5">
    <div id="article-container"></div>

    <!-- Bình luận -->
    <div id="comment-section" class="mt-5">
      <h4 class="text-neon">Bình luận</h4>
      <div id="comment-list" class="mt-3"></div>

      <?php if (isset($_SESSION['user'])): ?>
      <form id="comment-form" class="mt-4">
        <div class="mb-2">
          <textarea id="comment_content" class="form-control" rows="3" placeholder="Viết bình luận..." required></textarea>
        </div>
        <button type="submit" class="btn btn-neon">Gửi bình luận</button>
      </form>
      <?php else: ?>
      <p class="text-light">Vui lòng <a href="../../index.php?page=signin" class="text-neon">đăng nhập</a> để bình luận.</p>
      <?php endif; ?>
    </div>

    <!-- Gợi ý bài viết -->
    <section id="suggestions-container" class="mt-5">
      <h3 class="text-neon mb-3">Các bài viết khác</h3>
      <div id="suggestions-list" class="blog-container vertical-list"></div>
    </section>
  </main>

  <footer id="footer" class="cyber-footer py-5 mt-5" data-scroll></footer>
  <script src="detail.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
