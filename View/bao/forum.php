<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="/View/bao/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỏi Đáp - BKGame</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="forum.css">
    <style>
        .form-control::placeholder {
            color: white;
        }
    </style>
</head>

<body class="text-light" style="background-color: rgb(10, 10, 32);">
    <div id="header">
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
                                <li><a class="dropdown-item" href="#">PC Games</a></li>
                                <li><a class="dropdown-item" href="#">Console Games</a></li>
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
                        <button class="btn btn-outline-neon me-2">
                            <a href="../../index.php?page=signin" style="text-decoration: none; color: var(--primary);">Đăng Nhập</a>
                        </button>
                        
                        <button class="btn btn-neon">
                            <a href="../../index.php?page=signup" style="color: black; text-decoration: none;">Đăng Ký</a>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mt-5 visible" data-scroll="">
        <h1 class="text-neon-without-shadow text-center mb-5" data-editable="true" contenteditable="true">HỎI &amp; ĐÁP</h1>

        <div class="cyber-card mb-5 p-4 visible" data-scroll="">
            <h4 class="text-neon-without-shadow mb-4"><i class="bi bi-patch-question-fill"></i> Đặt câu hỏi</h4>
            <form id="questionForm" method="POST" action="../../Controller/FaqsController.php">
                <?php if (isset($_SESSION['user'])): ?>
                    <input type="hidden" id="user_id" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
                    <input type="hidden" id="user_name" name="user_name" value="<?= $_SESSION['user']['username'] ?>">
                <?php endif; ?> 

                <div class="mb-3">
                    <input type="text" class="form-control bg-transparent text-light" id="questionTitle" name="questionTitle" placeholder="Tiêu đề">
                </div>
                
                <div class="mb-3">
                    <textarea class="form-control bg-transparent text-light" id="questionContent" name="questionContent" style="height: 120px" placeholder="Nội dung"></textarea>
                </div>
                
                <?php if (!isset($_SESSION['user'])): ?>
                    <a type="button" href="../../index.php?page=signin" class="btn btn-neon"><i class="bi bi-send-fill"></i> Vui Lòng Đăng Nhập</a>
                <?php else: ?>
                    <button type="submit" class="btn btn-neon"><i class="bi bi-send-fill"></i> Gửi câu hỏi</button>
                <?php endif; ?> 
            </form>
        </div>

        <div class="cyber-card p-4" data-scroll="">
            <h4 class="text-neon-without-shadow mb-4"><i class="bi bi-chat-square-text-fill"></i> Câu hỏi gần đây</h4>
            
            <div id="faq-container"></div>

            <nav class="mt-4">
                <ul class="pagination justify-content-center" id="pagination-container"></ul>
            </nav>
        </div>
    </div>

    <footer id="footer" class="cyber-footer py-5 mt-5" data-scroll=""></footer>

    <script src="forum.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function fetchData(URL_String) {
            const URL_GAMES_API = new URL(URL_String, window.location.href).href;
            try {
                const response = await fetch(URL_GAMES_API);
                if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                return json;
            } catch (error) {
                console.error(error.message);
            }
        }

        function formatTime(dateTimeString) {
            return dateTimeString;
        }

        const itemsPerPage = 4;

        function renderPage(pageNumber, data) {
            const faqContainer = document.getElementById('faq-container');
            faqContainer.innerHTML = "";

            const startIndex = (pageNumber - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = data.slice(startIndex, endIndex);

            pageData.forEach(faq => {
                const faqItem = document.createElement('div');
                faqItem.className = 'question-item mb-4 p-3';
                faqItem.innerHTML = `
                <div class="question-header">
                    <h5 class="text-neon-without-shadow">${faq.question}</h5>
                    <small>Đăng bởi: ${faq.posted_by} - ${formatTime(faq.created_at)}</small>
                </div>
                <!-- Cấp chứa câu trả lời -->
                <div class="answers-container mt-3">
                    <div class="answer-item bg-card p-3 rounded">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-person-circle text-neon me-2"></i>
                        <span class="text-neon">${faq.posted_by}</span>
                        <small class="ms-3">${formatTime(faq.updated_at)}</small>
                    </div>
                    <p class="text-light mb-0">${faq.answer}</p>
                    </div>
                </div>
                <form class="mt-3">
                    <div class="input-group">
                    <input type="text" class="form-control bg-transparent text-light" placeholder="Viết câu trả lời...">
                    <button class="btn btn-neon"><i class="bi bi-reply-fill"></i></button>
                    </div>
                </form>
                `;
                faqContainer.appendChild(faqItem);
            });
        }

        function renderPagination(totalItems) {
            const paginationContainer = document.getElementById('pagination-container');
            paginationContainer.innerHTML = "";
            const totalPages = Math.ceil(totalItems / itemsPerPage);

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = "page-item";
                li.innerHTML = `<a class="page-link text-neon bg-dark" href="#">${i}</a>`;
                
                li.addEventListener('click', function(event) {
                event.preventDefault();
                renderPage(i, window.faqData);
                });
                paginationContainer.appendChild(li);
            }
        }

        document.addEventListener("DOMContentLoaded", async function() {
            const data = await fetchData("../../Controller/FaqsController.php");
            window.faqData = data;

            renderPage(1, data);
            renderPagination(data.length);
        });

        document.getElementById("questionForm").addEventListener("submit", async function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            const title = document.getElementById("questionTitle").value.trim();
            const content = document.getElementById("questionContent").value.trim();
            const userId = document.getElementById("user_id").value;
            const userName = document.getElementById("user_name").value;

            if (!title || !content) {
                alert("Vui lòng nhập đầy đủ tiêu đề và nội dung.");
                return;
            }

            formData.append("questionTitle", title);
            formData.append("questionContent", content);
            formData.append("user_id", userId);
            formData.append("user_name", userName);

            fetch("../../Controller/FaqsController.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || "Gửi câu hỏi thành công!");
                this.reset();
            })
            .catch(error => {
                console.error("Lỗi gửi dữ liệu:", error);
                alert("Có lỗi xảy ra khi gửi câu hỏi.");
            });
        });
    </script>
</body>
</html>