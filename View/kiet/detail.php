<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <base href="./View/kiet/">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BKGame - Chi Tiết Bài Viết</title>
  <!-- Link đến file CSS chi tiết (detail.css) chứa các biến, style của trang detail và style dùng chung cho các block bài viết -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="detail.css">
  <!-- Bootstrap (nếu cần) -->
</head>
<body class="text-light">
  <!-- Header: Nội dung sẽ được load từ component/header.html (với CSS của component được áp dụng bên trong file đó) -->
  <div id="header" data-scroll></div>
  
  <!-- Main Content -->
  <main class="container my-5">
    <!-- Bài viết chi tiết -->
    <div id="article-container"></div>
    
    <!-- Các bài viết khác (đề xuất) -->
    <section id="suggestions-container" class="mt-5">
      <h3 class="text-neon mb-3">Các bài viết khác</h3>
      <!-- Sử dụng blog-container để đặt các block bài viết theo cột dọc -->
      <div id="suggestions-list" class="blog-container vertical-list"></div>
    </section>
  </main>
  
  <!-- Footer: Nội dung sẽ được load từ component/footer.html -->
  <footer id="footer" class="cyber-footer py-5 mt-5" data-scroll></footer>
  
  <!-- Scripts -->
  <script src="detail.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
