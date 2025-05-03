<?php session_start(); ?>
<!DOCTYPE html>
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

    <header id="header"></header>

    <div class="container py-5">
        <div class="cyber-card p-4 mb-5" data-scroll="">
            <h4 class="text-neon-without-shadow mb-4"><i class="bi bi-send-fill"></i> Đặt câu hỏi</h4>
            <form id="ask-form" class="row g-3">
                <input type="hidden" id="user_id"   name="user_id"   value="<?= isset($_SESSION['user']) ? $_SESSION['user']['id'] : '' ?>">
                <input type="hidden" id="user_name" name="user_name" value="<?= isset($_SESSION['user']) ? $_SESSION['user']['username'] : '' ?>">
                <div class="col-12">
                    <input type="text" class="form-control bg-transparent text-light" id="questionTitle" name="questionTitle" placeholder="Tiêu đề" required>
                </div>
                <div class="col-12">
                    <textarea class="form-control bg-transparent text-light" id="questionContent" name="questionContent" rows="4" placeholder="Nội dung câu hỏi" required></textarea>
                </div>
                <div class="col-12 text-end">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <a href="../../index.php?login" class="btn btn-neon"><i class="bi bi-send-fill"></i> Vui lòng đăng nhập</a>
                    <?php else: ?>
                        <button type="submit" class="btn btn-neon"><i class="bi bi-send-fill"></i> Gửi câu hỏi</button>
                    <?php endif; ?>
                </div>
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
        const currentUser = <?= isset($_SESSION['user'])
            ? json_encode(['id'=>$_SESSION['user']['id'], 'username'=>$_SESSION['user']['username']])
            : 'null' ?>;

        async function fetchData(URL_String) {
            const URL_API = new URL(URL_String, window.location.href).href;
            try {
                const response = await fetch(URL_API);
                if (!response.ok) throw new Error(`Response status: ${response.status}`);
                return await response.json();
            } catch (error) {
                console.error(error);
                return [];
            }
        }

        function formatTime(dateString) {
            const dt = new Date(dateString);
            const pad = n => n.toString().padStart(2, '0');
            return `${pad(dt.getHours())}:${pad(dt.getMinutes())} ${pad(dt.getDate())}/${pad(dt.getMonth()+1)}/${dt.getFullYear()}`;
        }

        const itemsPerPage = 4;

        function attachReplyHandlers() {
            document.querySelectorAll('.reply-form').forEach(form => {
                if (form.dataset.hasListener) return;
                form.dataset.hasListener = '1';

                form.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    if (!currentUser) {
                        return window.location.href = '../../index.php?login';
                    }

                    const faqId = this.dataset.faqId;
                    const answerInput = this.querySelector('input[name="answer"]');
                    const text = answerInput.value.trim();
                    if (!text) {
                        return alert('Vui lòng nhập nội dung trả lời.');
                    }

                    const formData = new FormData();
                    formData.append('faq_id', faqId);
                    formData.append('answer', text);
                    formData.append('user_id', currentUser.id);
                    formData.append('user_name', currentUser.username);

                    try {
                        const res = await fetch('../../Controller/AnswersController.php', {
                            method: 'POST',
                            body: formData
                        });
                        const data = await res.json();
                        if (data.success) {
                            const answersContainer = form.previousElementSibling;
                            const item = document.createElement('div');
                            item.className = 'answer-item bg-card p-3 rounded mt-2';
                            item.innerHTML = `
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-person-circle text-neon me-2"></i>
                                    <span class="text-neon">${currentUser.username}</span>
                                    <small class="ms-3">${formatTime(new Date().toISOString())}</small>
                                </div>
                                <p class="text-light mb-0">${text}</p>
                            `;
                            answersContainer.appendChild(item);
                            answerInput.value = '';
                        } else {
                            alert(data.message||'Đã có lỗi khi gửi trả lời.');
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Lỗi khi gọi API trả lời.');
                    }
                });
            });
        }

        async function loadAnswers(containerEl, faqId) {
            containerEl.innerHTML = '<p class="text-light">Đang tải câu trả lời…</p>';
            const answers = await fetchData(`/Controller/AnswersController.php?faq_id=${faqId}`);
            containerEl.innerHTML = answers.map(ans => `
                <div class="answer-item bg-card p-3 rounded mb-2">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-circle text-neon me-2"></i>
                    <span class="text-neon">${ans.user_name}</span>
                    <small class="ms-3">${formatTime(ans.created_at)}</small>
                </div>
                <p class="text-light mb-0">${ans.content}</p>
                </div>
            `).join('') || '<p class="text-light">Chưa có câu trả lời nào.</p>';
        }

        function renderPage(pageNumber, data) {
            const container = document.getElementById('faq-container');
            container.innerHTML = '';
            const start = (pageNumber-1)*itemsPerPage;
            const slice = data.slice(start, start+itemsPerPage);

            slice.forEach(faq => {
                const faqItem = document.createElement('div');
                faqItem.className = 'question-item mb-4 p-3';
                faqItem.id = `faq-${faq.faq_id}`;
                faqItem.innerHTML = `
                    <div class="question-header">
                        <h5 class="text-neon-without-shadow">${faq.question}</h5>
                        <small>Đăng bởi: ${faq.posted_by} - ${formatTime(faq.created_at)}</small>
                    </div>
                    <div class="answers-container mt-3" data-faq-id="${faq.faq_id}">
                        ${ (faq.answers || []).map(ans => `
                            <div class="answer-item bg-card p-3 rounded mb-2">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-person-circle text-neon me-2"></i>
                                    <span class="text-neon">${ans.user_name}</span>
                                    <small class="ms-3">${formatTime(ans.created_at)}</small>
                                </div>
                                <p class="text-light mb-0">${ans.content}</p>
                            </div>
                        `).join('')}
                    </div>
                    <form class="mt-3 reply-form" data-faq-id="${faq.faq_id}">
                        <div class="input-group">
                            <input type="text" name="answer" class="form-control bg-transparent text-light" placeholder="Viết câu trả lời..." ${!currentUser?'disabled':''}>
                            ${!currentUser
                                ? `<button type="button" class="btn btn-neon" onclick="window.location='../../index.php?login'"><i class="bi bi-reply-fill"></i></button>`
                                : `<button type="submit" class="btn btn-neon"><i class="bi bi-reply-fill"></i></button>`
                            }
                        </div>
                    </form>
                `;
                container.appendChild(faqItem);
            });

            const totalPages = Math.ceil(data.length / itemsPerPage);
            const pag = document.getElementById('pagination-container');
            pag.innerHTML = '';
            for (let i=1; i<=totalPages; i++) {
                const li = document.createElement('li');
                li.className = 'page-item'+(i===pageNumber?' active':'');
                li.innerHTML = `<a class="page-link text-neon bg-dark" href="#">${i}</a>`;
                li.addEventListener('click', e=>{
                    e.preventDefault();
                    renderPage(i, data);
                    attachReplyHandlers();
                });
                pag.appendChild(li);
            }

            document.querySelectorAll('.answers-container').forEach(el => {
                const faqId = el.dataset.faqId;
                loadAnswers(el, faqId);
            });

            attachReplyHandlers();
        }

        document.addEventListener('DOMContentLoaded', async () => {
            if (typeof loadComponent === 'function') {
                loadComponent('header','../component/header.php');
                loadComponent('footer','../component/footer.php');
            }

            const data = await fetchData('../../Controller/FaqsController.php');
            renderPage(1, data);

            document.getElementById('ask-form').addEventListener('submit', async function(e){
                e.preventDefault();
                if (!currentUser) return window.location.href='../../index.php?login';
                const fd = new FormData(this);
                try {
                    const res = await fetch('../../Controller/FaqsController.php', {
                        method: 'POST',
                        body: fd
                    });
                    const js = await res.json();
                    if (js.success) {
                        alert('Gửi câu hỏi thành công!');
                        location.reload();
                    } else {
                        alert(js.message||'Lỗi gửi câu hỏi.');
                    }
                } catch(err) {
                    console.error(err);
                    alert('Có lỗi xảy ra.');
                }
            });
        });
    </script>
</body>
</html>
