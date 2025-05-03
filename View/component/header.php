<?php session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand text-neon" href="../thinh/index.html">
            <img src="../img/logo.png" width="40" height="40" class="rounded-circle me-2 glow-effect" alt="CyberGameHub Logo">BKGame
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-neon" href="../thinh/index.html">Trang Chủ</a></li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-neon" href="#" role="button" data-bs-toggle="dropdown">Games</a>
                    
                    <ul class="dropdown-menu cyber-dropdown">
                        <li><a class="dropdown-item" href="#">PC Games</a></li>
                        <li><a class="dropdown-item" href="#">Console Games</a></li>
                        <li><a class="dropdown-item" href="#">Mobile Games</a></li>
                        <li><a class="dropdown-item" href="#">VR Games</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link text-neon" href="../bao/about_us.php">Giới Thiệu</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../kiet/blogs.html">Tin Tức</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../bao/forum.php">Cộng Đồng</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../thinh/contact_us.html">Liên Hệ</a></li>
            
            </ul>
            
            <div class="d-flex align-items-center">
                <?php if (!isset($_SESSION['user'])): ?>
                <button class="btn btn-outline-neon me-2">
                    <a href="../common_part/signin.php" style="text-decoration: none; color: var(--primary);">
                        Đăng Nhập
                    </a>
                </button>
                
                <button class="btn btn-neon">
                    <a href="../common_part/signup.php" style="color: black; text-decoration: none;">
                        Đăng Ký
                    </a>
                </button>
                <?php else: ?>
                <button class="btn btn-outline-neon me-2">
                    <a href="../common_part/account-profile.php" style="text-decoration: none; color: var(--primary);">
                        Tài khoản
                    </a>
                </button>
                
                <button class="btn btn-neon">
                    <a href="../common_part/logout.php" style="color: black; text-decoration: none;">
                        Đăng Xuất
                    </a>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>