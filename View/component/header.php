<?php 
session_start(); 
$role = $_SESSION['user']['role'] ?? null;
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand text-neon" href="../../index.php?">
            <img src="../img/logo.png" width="40" height="40" class="rounded-circle me-2 glow-effect" alt="CyberGameHub Logo">BKGame
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?">Trang Chủ</a></li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-neon" href="#" role="button" data-bs-toggle="dropdown">Games</a>
                    
                    <ul class="dropdown-menu cyber-dropdown">
                        <li><a class="dropdown-item" href="/game_web/index.php?action=game">All Games</a></li>
                        <li><a class="dropdown-item" href="/game_web/index.php?action=platform">Platforms</a></li>
                        <li><a class="dropdown-item" href="#">Mobile Games</a></li>
                        <li><a class="dropdown-item" href="#">VR Games</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=about_us">Giới Thiệu</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=blogs">Tin Tức</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=forum">Cộng Đồng</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=contact_us">Liên Hệ</a></li>
            
            </ul>
            
            <div class="d-flex align-items-center">
                <?php if (!isset($_SESSION['user'])): ?>
                <button class="btn btn-outline-neon me-2">
                    <a href="../../index.php?page=signin" style="text-decoration: none; color: var(--primary);">
                        Đăng Nhập
                    </a>
                </button>
                
                <button class="btn btn-neon">
                    <a href="../../index.php?page=signup" style="color: black; text-decoration: none;">
                        Đăng Ký
                    </a>
                </button>
                <?php else: ?>
                <button class="btn btn-outline-neon me-2">
                    <a href="<?= $role !== 'admin' ? '../../index.php?page=account-profile' : '../../index.php?page=indexAdmin' ?>" style="text-decoration: none; color: var(--primary);">
                        Tài khoản
                    </a>
                </button>
                
                <button class="btn btn-neon">
                    <a href="/Controller/AuthController.php?action=logout" style="color: black; text-decoration: none;">
                        Đăng Xuất
                    </a>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>