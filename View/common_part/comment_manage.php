<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
$userId = $_SESSION['user']['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Quản lý comment</title>
    <link rel="stylesheet" href="../admin/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Câu hỏi của bạn</h2>
        <table class="admin-table" id="faq-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="faq-body">
                <!-- JavaScript sẽ render ở đây -->
            </tbody>
        </table>
    </div>

    <script>
        const userId = <?= json_encode($userId) ?>;
        fetch(`../../Controller/FaqsController.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                const body = document.getElementById('faq-body');
                if (data.length === 0) {
                    body.innerHTML = '<tr><td colspan="4">Không có câu hỏi nào.</td></tr>';
                    return;
                }

                body.innerHTML = data
                    .map(faq => `
                        <tr>
                            <td>${faq.faq_id}</td>
                            <td>${faq.question}</td>
                            <td>${faq.answer}</td>
                            <td>
                                <a href="../View/forum.html#id=${faq.faq_id}">Xem</a> |
                                <a href="#" onclick="deleteFaq(${faq.faq_id})">Xoá</a>
                            </td>
                        </tr>
                    `)
                    .join('');
            });

        function deleteFaq(faqId) {
            if (!confirm('Bạn có chắc muốn xoá?')) return;
            fetch(`../../Controller/FaqsController.php?delete=${faqId}`, {
                method: 'GET',
            })
            .then(() => location.reload());
        }
    </script>
</body>
</html>
