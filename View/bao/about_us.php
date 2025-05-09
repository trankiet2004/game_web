<?php
session_start();
$role = $_SESSION['user']['role'] ?? null;

$basePath = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($basePath, '/');
$apiUrl = 'http://' . $_SERVER['HTTP_HOST'] . $basePath . '/Controller/UsersController.php';
$jsonData = file_get_contents($apiUrl);
$users = json_decode($jsonData, true);

if (!is_array($users)) {
    echo "Không có bài viết nào để hiển thị.";
    exit;
}
?>

<html lang="en" data-theme="dark" style="--primary: rgb(210, 255, 0);"><head>
    <meta charset="UTF-8">
    <base href="./View/bao/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    
    <link rel="stylesheet" href="about_us.css">
</head>

<body class="text-light">
    <div class="header-banner visible" data-scroll="">
        <nav class="navbar navbar-expand-lg navbar-dark neon-border">
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
                                <li><a class="dropdown-item" href="../../index.php?action=game">All Games</a></li>
                                <li><a class="dropdown-item" href="../../index.php?action=platform">Platforms</a></li>
                                <li><a class="dropdown-item" href="../../index.php?action=genres">Genres</a></li>
                                <li><a class="dropdown-item" href="../../index.php?action=developer">Developers</a></li>
                                <li><a class="dropdown-item" href="../../index.php?action=tag">Tags</a></li>
                            </ul>
                        </li>
        
                        <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=about_us">Giới Thiệu</a></li>
                        
                        <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=blogs">Tin Tức</a></li>
                        
                        <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=forum">Cộng Đồng</a></li>
                        
                        <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=contact_us">Liên Hệ</a></li>
                    
                    </ul>
                    
                    <!-- START_PROTECTED_LOGIN_SNIPPET -->
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-neon me-2">
                            <a href="../../index.php?page=cart" style="text-decoration: none; color: var(--primary);">
                                <i class="bi bi-cart-fill"></i>
                            </a>
                        </button>
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
                            <a href="../../Controller/AuthController.php?action=logout" style="color: black; text-decoration: none;">
                                Đăng Xuất
                            </a>
                        </button>
                        <?php endif; ?>
                    </div>
                    <!-- END_PROTECTED_LOGIN_SNIPPET -->
                </div>
            </div>
        </nav>
    
        <div class="hero-section overflow-hidden">
            <h1 data-editable="true" style="font-size: 600%; font-weight: bold; text-align: center;" contenteditable="true">
                <span class="neon-outline">BK GAME</span>&nbsp;COMAPNY</h1>
    
            <h6 data-editable="true" style="text-align: center; font-weight: 400; font-size: 200%;" contenteditable="true">
                Tạo ra những trải nghiệm chơi game của tương lai</h6>
        </div>
    </div>

    <div class="status-section visible" data-scroll="">
        <div data-editable="true" class="status-section-item" contenteditable="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" viewBox="0 0 640 512">
                <path d="M192 64C86 64 0 150 0 256S86 448 192 448l256 0c106 0 192-86 192-192s-86-192-192-192L192 64zM496 168a40 40 0 1 1 0 80 40 40 0 1 1 0-80zM392 304a40 40 0 1 1 80 0 40 40 0 1 1 -80 0zM168 200c0-13.3 10.7-24 24-24s24 10.7 24 24l0 32 32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0 0 32c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-32-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l32 0 0-32z"></path>
            </svg>
            <h3 data-target="50" data-suffix="+">50+</h3>
            <p style="font-size: 100%;">Trò Chơi Đã Phát Hành</p>
        </div>

        <div data-editable="true" class="status-section-item" contenteditable="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" viewBox="0 0 640 512">
                <path d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3l0-84.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5l0 21.5c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32l0-26.8C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112l32 0c24 0 46.2 7.5 64.4 20.3zM448 416l0-21.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176l32 0c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2l0 26.8c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7l0 84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3l0-84.7c-10 11.3-16 26.1-16 42.3zm144-42.3l0 84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2l0 42.8c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32l0-42.8c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112l32 0c61.9 0 112 50.1 112 112z"></path>
            </svg>
            <h3 data-target="1000" data-suffix="+">1000+</h3>
            <p style="font-size: 100%;">Người Chơi Tích Cực</p>
        </div>
        
        <div data-editable="true" class="status-section-item" contenteditable="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" viewBox="0 0 640 512">
                <path d="M400 0L176 0c-26.5 0-48.1 21.8-47.1 48.2c.2 5.3 .4 10.6 .7 15.8L24 64C10.7 64 0 74.7 0 88c0 92.6 33.5 157 78.5 200.7c44.3 43.1 98.3 64.8 138.1 75.8c23.4 6.5 39.4 26 39.4 45.6c0 20.9-17 37.9-37.9 37.9L192 448c-17.7 0-32 14.3-32 32s14.3 32 32 32l192 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-26.1 0C337 448 320 431 320 410.1c0-19.6 15.9-39.2 39.4-45.6c39.9-11 93.9-32.7 138.2-75.8C542.5 245 576 180.6 576 88c0-13.3-10.7-24-24-24L446.4 64c.3-5.2 .5-10.4 .7-15.8C448.1 21.8 426.5 0 400 0zM48.9 112l84.4 0c9.1 90.1 29.2 150.3 51.9 190.6c-24.9-11-50.8-26.5-73.2-48.3c-32-31.1-58-76-63-142.3zM464.1 254.3c-22.4 21.8-48.3 37.3-73.2 48.3c22.7-40.3 42.8-100.5 51.9-190.6l84.4 0c-5.1 66.3-31.1 111.2-63 142.3z"></path>
            </svg>
            <h3 data-target="200" data-suffix="+">200+</h3>
            <p style="font-size: 100%;">Giải Thưởng Đạt Được</p>
        </div>

        <div data-editable="true" class="status-section-item" contenteditable="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" viewBox="0 0 512 512">
                <path d="M352 256c0 22.2-1.2 43.6-3.3 64l-185.3 0c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64l185.3 0c2.2 20.4 3.3 41.8 3.3 64zm28.8-64l123.1 0c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64l-123.1 0c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32l-116.7 0c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0l-176.6 0c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0L18.6 160C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192l123.1 0c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64L8.1 320C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6l176.6 0c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352l116.7 0zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6l116.7 0z"></path>
            </svg>
            <h3 data-target="30" data-suffix="+">30+</h3>
            <p style="font-size: 100%;">Quốc Gia Đã Tiếp Cận</p>
        </div>
    </div>

    <!-- <div class="our-journey-section">
        <div style="width: 100%; margin: 3% 0;">
            <h3>Hành Trình Của Chúng Tôi</h3>
        </div>

        <div class="our-journey-section-child">
            <h4>2020 - Khởi Nguồn Đột Phá</h4>
            <p>Chính thức ra mắt, khởi xướng cuộc cách mạng phân phối game với tầm nhìn chinh phục thị trường triệu đô.</p>
        </div>

        <div class="our-journey-section-child">
            <h4>2021 - Bước Nhảy Vọt</h4>
            <p>Mở rộng hợp tác với các nhà phát triển AAA, thu hút hàng triệu game thủ nhờ nền tảng phân phối hiện đại.</p>
        </div>

        <div class="our-journey-section-child">
            <h4>2022 - Tạo Xu Hướng Mới</h4>
            <p>Ra mắt dịch vụ cloud gaming và VR, nâng tầm trải nghiệm chơi game và dẫn dắt xu hướng công nghệ mới.</p>
        </div>

        <div class="our-journey-section-child">
            <h4>2023 - Vươn Tầm Quốc Tế</h4>
            <p>Vươn tầm quốc tế với 5 studio toàn cầu, khẳng định vị thế trong cộng đồng eSports và giải đấu chuyên nghiệp.</p>
        </div>

        <div class="our-journey-section-child">
            <h4>2024 - Tăng Tốc Bền Vững</h4>
            <p>Đột phá với AI và big data, cá nhân hóa dịch vụ và khẳng định thương hiệu dẫn đầu ngành game.</p>
        </div>

        <div class="our-journey-section-child">
            <h4>2025 - Dẫn Đầu Xu Thế</h4>
            <p>Tiếp tục mở rộng toàn cầu, trở thành biểu tượng cho tinh thần sáng tạo và đam mê trong thế giới game.</p>
        </div>
    </div> -->

    <div class="time-line-container visible" data-scroll="">
        <div class="row" style="width: 100%; margin: 0; padding: 0;">
            <div class="col col-12">
                <h3>Hành Trình Của Chúng Tôi</h3>
            </div>
        </div>

        <div class="row" style="margin: 1%;">
            <div class="col col-6" style="border-right: 4px solid aqua;" data-editable="true" contenteditable="true">
                <div data-scroll="" class="visible" style="position: relative;">
                    <h4>2018 - Khởi Nguồn Đam Mê</h4>
                    <p>Thành lập với khát khao chinh phục thị trường game triệu đô, đặt nền móng cho những trải nghiệm chơi game đẳng cấp toàn cầu.</p>
                <button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button></div>

                <div style="margin-top: 10%; position: relative;" data-scroll="" class="visible">
                    <h4>2020 - Dấu Ấn AAA</h4>
                    <p>Phối hợp với các studio quốc tế, mang về những tựa game AAA độc quyền, khẳng định vị thế công ty phân phối uy tín.</p>
                <button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button></div>

                <div style="margin-top: 10%; position: relative;" data-scroll="" class="visible">
                    <h4>2022 - Định Hình Xu Hướng Mới</h4>
                    <p>Ra mắt chương trình hỗ trợ nhà phát triển indie, củng cố hệ sinh thái streaming và mở rộng hợp tác chiến lược toàn cầu.</p>
                <button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button></div>

                <div style="margin-top: 10%; position: relative;" data-scroll="" class="visible">
                    <h4>2024 - Tăng Tốc Bền Vững</h4>
                    <p>Xây dựng cộng đồng eSports quốc tế, đầu tư mạnh vào AI và luôn đặt trải nghiệm người chơi làm trung tâm.</p>
                <button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button></div>
            </div>

            <div class="col col-6" style="border-left: 4px solid aqua; padding-top: 6%; padding-left: 4%;" data-editable="true" contenteditable="true">
                <div data-scroll="" class="visible" style="position: relative;">
                    <h4>2019 - Bứt Phá Ban Đầu</h4>
                    <p>Mở rộng mạng lưới phân phối, ra mắt nền tảng trực tuyến và ghi dấu ấn thương hiệu tiên phong trong cộng đồng game thủ.</p>
                <button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button></div>

                <div style="margin-top: 10%; position: relative;" data-scroll="" class="visible">
                    <h4>2021 - Lan Tỏa Sức Ảnh Hưởng</h4>
                    <p>Đột phá về lượng người dùng, tham gia sự kiện eSports tầm cỡ và khẳng định thương hiệu qua chiến dịch marketing sáng tạo.</p>
                <button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button></div>

                <div style="margin-top: 10%; position: relative;" data-scroll="" class="visible">
                    <h4>2023 - Vươn Ra Thế Giới</h4>
                    <p>Mở rộng quy mô toàn cầu với 5 studio, chinh phục giải thưởng ngành game danh giá và khai trương trụ sở sáng tạo.</p>
                <button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button></div>

                <div style="margin-top: 10%; position: relative;" data-scroll="" class="visible">
                    <h4>2025 - Tiếp Nối Hành Trình</h4>
                    <p>Hoàn thiện hệ sinh thái game toàn diện, không ngừng sáng tạo và hướng đến vị thế hàng đầu châu Á về phân phối và phát triển game.</p>
                <button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button><button class="btn btn-danger btn-sm delete-btn" style="position: absolute; top: 5px; right: 5px;">Xóa</button></div>
            </div>
        </div>
    </div>

    <div class="meet-our-team-section visible" data-scroll="">
        <div style="width: 100%; margin: 3% 0;">
            <h3>Gặp gỡ đội nhóm của chúng tôi</h3>
        </div>

        <div class="team-card-container">
            <div class="card">
                <img src="../img/avatar/chu_tich_hoi_dong_quan_tri.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4>Trần Tuấn Kiệt</h4>
                    <p class="card-text">Tổng giám đốc điều hành</p>
                </div>
            </div>

            <div class="card">
                <img src="../img/avatar/chu_tich_hoi_dong_quan_tri.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4>Trần Tuấn Kiệt</h4>
                    <p class="card-text">Giám đốc sáng tạo</p>
                </div>
            </div>

            <div class="card">
                <img src="../img/avatar/chu_tich_hoi_dong_quan_tri.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4>Trần Tuấn Kiệt</h4>
                    <p class="card-text">Trưởng nhóm kỹ thuật</p>
                </div>
            </div>

            <div class="card">
                <img src="../img/avatar/chu_tich_hoi_dong_quan_tri.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4>Trần Tuấn Kiệt</h4>
                    <p class="card-text">Giám đốc nghệ thuật</p>
                </div>
            </div>
        </div>
    </div>

    <div class="vision-mission-container visible" data-scroll="">
        <div class="row">
            <div class="col col-6 visible" style="padding: 0 4%; border-right: 4px solid aqua;" data-scroll="">
                <h6>Sứ Mệnh Của Chúng Tôi</h6>
                
                <div class="mission-grid">
                    <div class="mission-card visible" data-scroll="">
                        <div class="cyber-border"></div>
                        <i class="bi bi-cpu-fill neon-pulse"></i>
                        <h4>Sáng Tạo Không Giới Hạn</h4>
                        <p>Ứng dụng AI và công nghệ thực tế ảo trong mọi tựa game</p>
                        <div class="neon-underline"></div>
                    </div>
                
                    <div class="mission-card visible" data-scroll="">
                        <div class="cyber-border"></div>
                        <i class="bi bi-shield-shaded neon-pulse"></i>
                        <h4>Chất Lượng Đỉnh Cao</h4>
                        <p>300+ kỹ sư game cam kết chất lượng từng pixel</p>
                        <div class="neon-underline"></div>
                    </div>
                
                    <div class="mission-card visible" data-scroll="">
                        <div class="cyber-border"></div>
                        <i class="bi bi-globe2 neon-pulse"></i>
                        <h4>Kết Nối Toàn Cầu</h4>
                        <p>Hệ thống máy chủ 50+ quốc gia - Ping ổn định &lt;15ms</p>
                        <div class="neon-underline"></div>
                    </div>
                </div>
            </div>
    
            <div class="col col-6 visible" style="padding: 0 4%; border-left: 4px solid aqua;" data-scroll="">
                <h6>Tầm Nhìn Của Chúng Tôi</h6>
    
                <div class="vision-hud visible" data-scroll="">
                    <div class="hud-container">
                        <div class="scanline"></div>
                        <div class="hud-content glitch-text">
                            <span class="hud-title">TẦM NHÌN 2028</span>
                            <div class="hud-grid">
                                <div class="hud-item">
                                    <div class="hexagon-wrapper">
                                        <div class="hexagon"><i class="bi bi-bezier2"></i></div>
                                    </div>
                                    <h4>Metaverse Integration</h4>
                                    <p class="terminal-text">Kết nối đa vũ trụ game qua blockchain</p>
                                </div>
                
                                <div class="hud-item">
                                    <div class="hexagon-wrapper">
                                        <div class="hexagon"><i class="bi bi-motherboard"></i></div>
                                    </div>
                                    <h4>Neural Interface</h4>
                                    <p class="terminal-text">Công nghệ tương tác thần kinh 2026</p>
                                </div>
                
                                <div class="hud-item">
                                    <div class="hexagon-wrapper">
                                        <div class="hexagon"><i class="bi bi-infinity"></i></div>
                                    </div>
                                    <h4>Infinite Reality</h4>
                                    <p class="terminal-text">Thế giới game tự sinh bằng AI quantum</p>
                                </div>
                            </div>
                            
                            <div class="hud-footer">
                                <span class="blink">▼</span> SYSTEM STATUS: <span class="neon-green">ONLINE</span>
                                <span class="ping">LATENCY: <span class="neon-cyan">8ms</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="our-latest-game-section visible" data-scroll="">
        <div style="width: 100%; margin: 2% 0;">
            <h3>Games Mới Nhất Của Chúng Tôi</h3>
        </div>
        <div class="game-card-container">
            <div class="game-card-wrapper"><div class="card"><img class="card-img-top" src="../data/img/games/game41494.jpg" alt="cyberpunk-2077"><div class="card-body"><h4>Cyberpunk 2077</h4><a href="https://www.cyberpunk.net/" class="btn btn-primary">Xem thêm</a></div></div><div class="card"><img class="card-img-top" src="../data/img/games/game290856.jpg" alt="apex-legends"><div class="card-body"><h4>Apex Legends</h4><a href="https://www.ea.com/games/apex-legends" class="btn btn-primary">Xem thêm</a></div></div><div class="card"><img class="card-img-top" src="../data/img/games/game28.jpg" alt="red-dead-redemption-2"><div class="card-body"><h4>Red Dead Redemption 2</h4><a href="https://www.rockstargames.com/reddeadredemption2/" class="btn btn-primary">Xem thêm</a></div></div><div class="card"><img class="card-img-top" src="../data/img/games/game58175.jpg" alt="god-of-war-2"><div class="card-body"><h4>God of War (2018)</h4><a href="https://godofwar.playstation.com/" class="btn btn-primary">Xem thêm</a></div></div><div class="card"><img class="card-img-top" src="../data/img/games/game32.jpg" alt="destiny-2"><div class="card-body"><h4>Destiny 2</h4><a href="https://www.bungie.net/7/en/Destiny/NewLight" class="btn btn-primary">Xem thêm</a></div></div><div class="card"><img class="card-img-top" src="../data/img/games/game41.jpg" alt="little-nightmares"><div class="card-body"><h4>Little Nightmares</h4><a href="http://www.little-nightmares.com" class="btn btn-primary">Xem thêm</a></div></div></div>
        </div>
    </div>
        
    

    <!-- <div class="contact-us-section">
        <div style="width: 100%; margin: 2% 0;">
            <h3>Liên Hệ</h3>
        </div>

        <div class="row">
            <div class="col col-6">
                <form action="">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Tên Của Bạn">
                        <label for="floatingInput">Tên Của Bạn</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Địa Chỉ Email</label>
                    </div>
                      
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Bình Luận" id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Bình Luận</label>
                    </div>
                </form>
            </div>

            <div class="col col-6">
                <div class="company-info">
                    <h4 class="text-neon">Văn Phòng Của Chúng Tôi</h4>

                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                            </svg>
                            268 Lý Thường Kiệt, Phường 14, Quận 10, Thành phố Hồ Chí Minh
                        </li>

                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                            </svg>
                            028 3864 7256
                        </li>

                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at-fill" viewBox="0 0 16 16">
                                <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671"/>
                                <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791"/>
                            </svg>
                            contact@hcmut.edu.vn
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->

    <footer id="footer" class="cyber-footer py-5" style="margin-top: 0;" data-scroll="">
<footer class="py-4" style="margin-top: 10rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h3 class="text-neon">Về BKGame</h3>
                <h5>Tạo ra những trải nghiệm chơi game của tương lai</h5>
            </div>
            
            <div class="col-lg-4">
                <h3 class="text-neon">Quick Links</h3>
                <ul class="list-unstyled">
                    <li><a href="#" style="text-decoration: none;">Hỗ Trợ</a></li>
                    <li><a href="#" style="text-decoration: none;">Điều khoản dịch vụ</a></li>
                    <li><a href="#" style="text-decoration: none;">Chính sách bảo mật</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4">
                <h3 class="text-neon">Phương Thức Thanh Toán</h3>
                
                <div class="payment-methods">
                    <i class="bi bi-credit-card" style="font-size: 2rem;"></i>
                    <i class="bi bi-paypal" style="font-size: 2rem;"></i>
                    <i class="bi bi-wallet2" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</footer>
</footer>

    <script src="about_us.js" data-scroll=""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-scroll=""></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" data-scroll=""></script>

    <script data-scroll="">
        function getApiUrl(path) {
            const segments = window.location.pathname.split("/").filter(Boolean);
            const basePath = segments.length >= 2 ? `/${segments[0]}` : "";
            return `${window.location.origin}${basePath}/${path}`;
        }

        async function fetchData() {
            const URL_GAMES_API = new URL(getApiUrl("Controller/GamesController.php"), window.location.href).href;

            try {
                const formData = new URLSearchParams();
                formData.append("action", "load_products");

                const response = await fetch(URL_GAMES_API, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();
                return json.data;
            } catch (error) {
                console.error("Error fetch:", error.message);
            }
        }
    
        document.addEventListener("DOMContentLoaded", async function() {
            if (window.self === window.top) {
                var editableEls = document.querySelectorAll('[data-editable="true"]');
                editableEls.forEach(function(el) {
                    el.contentEditable = false;
                });
                
                document.querySelectorAll(".delete-btn").forEach(function(btn) {
                    btn.remove();
                });
            }
    
            const data = await fetchData();
            let gameCardContainer = document.getElementsByClassName("game-card-wrapper")[0];
            gameCardContainer.innerHTML = "";
                            
            data.forEach((item, index) => {
                if (index >= 6) return;
                let newGameCard = document.createElement("div");
                newGameCard.classList.add("card");
                let newGameCardImg = document.createElement("img");
                newGameCardImg.classList.add("card-img-top");
                newGameCardImg.src = `../data/${item['background_image']}`;
                newGameCardImg.alt = item['slug'];
                let newGameCardBody = document.createElement("div");
                newGameCardBody.classList.add("card-body");
                let newGameCardBodyH4 = document.createElement("h4");
                newGameCardBodyH4.innerHTML = item['name'];
                let newGameCardBodyA = document.createElement("a");
                newGameCardBodyA.href = item['website'];
                newGameCardBodyA.classList.add("btn", "btn-primary");
                newGameCardBodyA.innerHTML = "Xem thêm";
                newGameCardBody.append(newGameCardBodyH4, newGameCardBodyA);
                newGameCard.append(newGameCardImg, newGameCardBody);                
                gameCardContainer.append(newGameCard);
            });
    
            if (window.self !== window.top) {
                var timelineEntries = document.querySelectorAll(".time-line-container div[data-scroll].visible");
                timelineEntries.forEach(function(entry) {
                    if (entry.querySelector("h4") && entry.querySelector("p")) {
                        addDeleteButton(entry);
                    }
                });
            }
    
            function addDeleteButton(entry) {
                var deleteBtn = document.createElement("button");
                deleteBtn.innerText = "Xóa";
                deleteBtn.className = "btn btn-danger btn-sm delete-btn";
                entry.style.position = "relative";
                deleteBtn.style.position = "absolute";
                deleteBtn.style.top = "5px";
                deleteBtn.style.right = "5px";
                deleteBtn.addEventListener("click", function(e) {
                    e.stopPropagation();
                    if (confirm("Bạn có chắc chắn muốn xóa mục này không?")) {
                        entry.remove();
                    }
                });
                entry.appendChild(deleteBtn);
            }
        });
    </script>

</body></html>