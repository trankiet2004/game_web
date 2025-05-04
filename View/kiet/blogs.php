<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="./View/kiet/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - BKGame</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="blogs.css">
</head>
<body class="text-light">
    <div id="header" data-scroll></div>

    <!-- Hero Section -->
    

    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="text-center text-neon mb-5">Các Bài Viết Mới Nhất</h2>

        <div class="search-box mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm bài viết...">
        </div>

        <!-- Blog Container -->
        <div class="blog-container row">
            <!-- Các bài viết sẽ được thêm vào đây thông qua JavaScript -->
        </div>
        
        <!-- Pagination -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center"></ul>
        </nav>
    </div>

    <!-- Footer -->
    <footer id="footer" class="cyber-footer py-5 mt-5" data-scroll></footer>


    <script src="blogs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>