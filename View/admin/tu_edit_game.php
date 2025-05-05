<?php
session_start();

// 1. Chưa đăng nhập → quay về login
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php?page=signin');
    exit;
}
$role = $_SESSION['user']['role'] ?? null;

// 2. Đã đăng nhập nhưng không phải admin → 403 Forbidden
if ($role !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền truy cập trang này.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="./View/admin/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Các Trang</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../node_modules/sweetalert2/dist/sweetalert2.min.css">

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

        td a {
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
            background-color: green;
            color: white;
        }

        /* Fix table size and prevent zooming/shrinking */
        .table-responsive {
            max-height: 700px;
            /* Set a fixed height for the table */
            overflow-y: auto;
            /* Add a vertical scrollbar if content exceeds max height */
        }

        /* Ensure table content does not shrink when the number of rows is small */
        .table {
            table-layout: fixed;
            /* Enable fixed column widths */
            width: 100%;
            /* Ensure table takes up the full width */
        }

        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 5%;
            /* 10% width for the first column (checkbox) */
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 30%;
            /* 30% width for the second column (Game Name) */
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 15%;
            text-align: center;
            /* 20% width for the third column (Release Date) */
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 5%;
            /* 15% width for the fourth column (Price) */
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 10%;
            text-align: center;
            /* 15% width for the fifth column (Rating) */
        }

        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 5%;
            /* 10% width for the sixth column (Actions) */
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 15%;
            text-align: center;
            /* 10% width for the sixth column (Actions) */
        }
        /* Style the container of the screenshot */
        .screenshot-container {
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Style the delete button */
        .delete-btn {
            position: absolute;
            top: 0px;  /* Adjust as needed to position it above the image */
            right: 0%;
            transform: translateX(-50%);  /* Center the button horizontally */
            background-color: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 50%;
        }

        /* Optional: Add some space around the image */
        .screenshot-container img {
            display: block;
            margin-top: 20px;  /* Create space below the delete button */
        }
        /* Style for the Add Screenshot button */
        .add-screenshot-btn {
            background-color: #28a745;  /* Green color */
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-block;
        }

        /* Hover effect */
        .add-screenshot-btn:hover {
            background-color: #218838;  /* Darker green */
            transform: scale(1.05);  /* Slightly increase the button size */
        }

        /* Active state */
        .add-screenshot-btn:active {
            background-color: #1e7e34;  /* Even darker green */
            transform: scale(0.98);  /* Shrink the button slightly */
        }

        /* Focus style (for accessibility) */
        .add-screenshot-btn:focus {
            outline: none;  /* Remove the default outline */
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.5);  /* Add a glow effect around the button */
        }
        /* Style for the upload form container */
        #upload-form {
            background-color: #f8f9fa; /* Light background color */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto; /* Center the form */
            display: none; /* Initially hidden */
            transition: opacity 0.3s ease-in-out;
        }

        /* Style for the label */
        #upload-form label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            color: #333;
        }

        /* Style for the file input */
        .upload-input {
            display: block;
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
        }

        .upload-input:focus {
            border-color: #28a745;
            outline: none;
        }

        /* Style for the upload button */
        .upload-btn {
            background-color: #28a745;  /* Green color */
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 40%;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            width: 100%; /* Make button take up full width */
        }

        .upload-btn:hover {
            background-color: #218838;  /* Darker green */
        }

        .upload-btn:active {
            background-color: #1e7e34;  /* Even darker green */
        }

        /* Show form with fade-in effect when it becomes visible */
        #upload-form.show {
            display: block;
            opacity: 1;
        }

    </style>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            let file = "./admin_component/sidebar.html";
            let id = "sidebar";
            fetch(file).then(response => response.text())
                .then(data => {
                    document.getElementById(id).innerHTML = data;
                    $("li:has(i.fas.fa-gamepad)").addClass("active");
                    const toggler = document.getElementById("toggle-dark");
                    if (!toggler) return;
                    const theme = localStorage.getItem("theme");
                    toggler.checked = theme === "dark";
                    toggler.addEventListener("input", (e) => {
                        if (e.target.checked) {
                            document.body.classList.add("dark");
                            document.documentElement.setAttribute("data-bs-theme", "dark");
                            localStorage.setItem("theme", "dark");
                        } else {
                            document.body.classList.remove("dark");
                            document.documentElement.setAttribute("data-bs-theme", "light");
                            localStorage.setItem("theme", "light");
                        }
                    });
                }).catch(error => {
                    console.error(`Lỗi khi tải ${file}:`, error);
                });
        });

        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.selectRow');
            checkboxes.forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar"></div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Quản Lý Games</h3>
                            <p class="text-subtitle text-muted">Quản lý games dành cho quản trị viên.</p>
                        </div>
                        <div class="col-md-6">
                            <nav class="breadcrumb-header float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../../index.php?page=indexAdmin">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Quản Lý Games</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Thông tin Game</h5>
                            <a id="deleteSelected" class="btn btn-danger disabled">Xoá Các Game Đã Chọn</a>
                        </div>

                        <div class="card-body">
                            <?php if ($game): ?>
                                <?php if (!empty($game['background_image'])): ?>
                                    <div class="position-relative mb-4" style="z-index: 1;">
                                        <div class="position-absolute top-0 start-0 w-100 h-100"
                                            style="background: url('../data/<?= htmlspecialchars($game['background_image']) ?>') center/cover no-repeat; opacity: 0.2; z-index: 0;">
                                        </div>
    
                                        <div style="position: relative; z-index: 1;padding: 20px;">
                                            <h3><span id="game-name"><?= htmlspecialchars($game['name']) ?></span></h3>
                                            <p><strong>Ngày phát hành:</strong>
                                                <span id="game-released"><?= $game['released'] ?></span>
                                            </p>
                                            <p><strong>Giá:</strong>
                                                <span id="game-price"><?= $game['price'] ?></span> VNĐ
                                            </p>
                                            <p><strong>Đánh giá:</strong>
                                                <span id="game-rating"><?= $game['rating'] ?></span> |
                                                <strong>Meta:</strong> <span id="game-meta"><?= $game['metacritic'] ?></span>
                                            </p>
                                            <p><strong>Mô tả:</strong>
                                                <span id="game-description"><?= htmlspecialchars($game['description']) ?></span>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
    
                                <hr>
    
                                <p><strong>Thể loại:</strong>
                                    <span id="genre-list">
                                        <?php foreach ($game['genres'] as $genre): ?>
                                            <span class="badge bg-primary"><?= htmlspecialchars($genre['name']) ?></span>
                                        <?php endforeach; ?>
                                        <span type="button" id="genre-edit" class="badge bg-primary"
                                            style="cursor:pointer;display:none;">Chỉnh sửa thể loại</span>
                                    </span>
    
                                    <!-- Hidden genre form -->
                                <form id="genre-form" action="../../index.php?action=updateGenres&id=<?= $game['id'] ?>" method="post"
                                    style="display:none; margin-top: 10px;">
                                    <?php foreach ($allGenre as $genre): ?>
                                        <?php $checked = in_array($genre['id'], array_column($game['genres'], 'id')) ? 'checked' : ''; ?>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="genres[]" value="<?= $genre['id'] ?>" <?= $checked ?>>
                                            <?= htmlspecialchars($genre['name']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;">Lưu thể
                                        loại</button>
                                </form>
                                </p>
    
    
                                <!-- Chỉnh sửa phần Tags trong HTML -->
                                <p><strong>Tags:</strong>
                                    <span id="tag-list">
                                        <?php foreach ($game['tags'] as $tag): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($tag['name']) ?></span>
                                        <?php endforeach; ?>
                                        <span type="button" id="tag-edit" class="badge bg-success"
                                            style="cursor:pointer;display:none;">Chỉnh sửa tags</span>
                                    </span>
    
                                    <!-- Hidden tag form -->
                                <form id="tag-form" action="../../index.php?action=updateTags&id=<?= $game['id'] ?>" method="post"
                                    style="display:none; margin-top: 10px;">
                                    <?php foreach ($allTags as $tag): ?>
                                        <?php $checked = in_array($tag['id'], array_column($game['tags'], 'id')) ? 'checked' : ''; ?>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" <?= $checked ?>>
                                            <?= htmlspecialchars($tag['name']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;">Lưu
                                        tags</button>
                                </form>
                                </p>
    
    
                                <p><strong>Nền tảng:</strong>
                                    <span id="platform-list">
                                        <?php foreach ($game['platforms'] as $platform): ?>
                                            <span class="badge bg-info text-dark"><?= htmlspecialchars($platform['name']) ?></span>
                                        <?php endforeach; ?>
                                        <span type="button" id="platform-edit" class="badge bg-info text-dark"
                                            style="cursor:pointer;display:none;">Chỉnh sửa nền tảng</span>
                                    </span>
    
                                    <!-- Hidden platform form -->
                                <form id="platform-form" action="../../index.php?action=updatePlatforms&id=<?= $game['id'] ?>"
                                    method="post" style="display:none; margin-top: 10px;">
                                    <?php foreach ($allPlatform as $platform): ?>
                                        <?php $checked = in_array($platform['id'], array_column($game['platforms'], 'id')) ? 'checked' : ''; ?>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="platforms[]" value="<?= $platform['id'] ?>" <?= $checked ?>>
                                            <?= htmlspecialchars($platform['name']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;">Lưu nền
                                        tảng</button>
                                </form>
                                </p>
    
    
                                <p><strong>Nhà phát triển:</strong>
                                    <span id="developer-list">
                                        <?php foreach ($game['developers'] as $dev): ?>
                                            <span class="badge bg-warning text-dark"><?= htmlspecialchars($dev['name']) ?></span>
                                        <?php endforeach; ?>
                                        <span type="button" id="developer-edit" class="badge bg-warning text-dark"
                                            style="cursor:pointer;display:none;">Chỉnh sửa nhà phát triển</span>
                                    </span>
    
                                    <!-- Hidden developer form -->
                                <form id="developer-form" action="../../index.php?action=updateDevelopers&id=<?= $game['id'] ?>"
                                    method="post" style="display:none; margin-top: 10px;">
                                    <?php foreach ($allDev as $dev): ?>
                                        <?php $checked = in_array($dev['id'], array_column($game['developers'], 'id')) ? 'checked' : ''; ?>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="developers[]" value="<?= $dev['id'] ?>" <?= $checked ?>>
                                            <?= htmlspecialchars($dev['name']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;">Lưu nhà phát
                                        triển</button>
                                </form>
                                </p>
    
    
                                <p><strong>Ảnh chụp màn hình:</strong></p>
                                <div class="d-flex flex-wrap gap-2" id="game-screenshots">
                                    <?php 
                                    // Assuming $game['screenshots'] contains all the screenshot data for the game
                                    foreach ($game['screenshots'] as $shot): ?>
                                        <div class="screenshot-container">
                                            <!-- Delete button above the image -->
                                            <button class="delete-btn" data-img-path="<?= $shot['img_path'] ?>" onclick="deleteScreenshot('<?= $shot['img_path'] ?>') " style="display:none;">x</button>
                                            <!-- Image display -->
                                            <img src="../data/<?= htmlspecialchars($shot['img_path']) ?>" alt="Screenshot" style="width: 150px; height: auto;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>


                                <!-- Add new screenshot button -->
                                <button type="button" class="add-screenshot-btn" onclick="showUploadForm()" style="display: none;">+ Add Screenshot</button>
                                <!-- Upload form (hidden initially) -->
                                <div id="upload-form" style="display: none;">
                                    <form id="screenshot-upload-form" enctype="multipart/form-data" class="upload-form">
                                        <label for="screenshot">Choose a screenshot:</label>
                                        <input type="file" name="screenshot" id="screenshot" accept="image/*" class="upload-input">
                                        <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                                        <button type="submit" class="upload-btn">Upload Screenshot</button>
                                    </form>
                                </div>


    
                                <p class="mt-3"><strong>Đánh giá người dùng:</strong></p>
                                <ul id="game-ratings">
                                    <?php foreach ($game['ratings'] as $rating): ?>
                                        <li>Exceptional: <?= (int) $rating['exceptional'] ?></li>
                                        <li>Recommended: <?= (int) $rating['recommended'] ?></li>
                                        <li>Meh: <?= (int) $rating['meh'] ?></li>
                                        <li>Skip: <?= (int) $rating['skip'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
    
                                <button class="btn btn-warning mt-3" onclick="enableEditMode()">Chỉnh sửa</button>
                                <button class="btn btn-success mt-3 d-none" id="saveButton">Lưu</button>
    
                            <?php else: ?>
                                <p class="text-danger">Không tìm thấy thông tin game.</p>
                            <?php endif; ?>
                        </div>
    
    
                    </div>
                    <div id="pagination-container" class="mt-3 text-center"></div>
                </section>
            </div>
        </div>
    </div>
    
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function enableEditMode() {
            // Make fields editable
            document.getElementById('game-name').contentEditable = true;
            document.getElementById('game-released').contentEditable = true;
            document.getElementById('game-price').contentEditable = true;
            document.getElementById('game-rating').contentEditable = true;
            document.getElementById('game-meta').contentEditable = true;
            document.getElementById('game-description').contentEditable = true;

            // Show "Chỉnh sửa" buttons for list fields
            document.getElementById('genre-edit').style.display = 'inline';
            document.getElementById('tag-edit').style.display = 'inline';
            document.getElementById('platform-edit').style.display = 'inline';
            document.getElementById('developer-edit').style.display = 'inline';

            // Show Save button, hide Edit button
            document.querySelector('button.btn-warning').classList.add('d-none'); // Edit button
            document.getElementById('saveButton').classList.remove('d-none');     // Save button

            // Show the delete buttons and the add screenshot button when in edit mode
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const addButton = document.querySelector('.add-screenshot-btn');

            // Change the display style of the delete buttons and add button
            deleteButtons.forEach(button => {
                button.style.display = 'inline-block'; // Show delete buttons
            });
            addButton.style.display = 'inline-block'; // Show add screenshot button

            // Show the upload form as well
            // document.getElementById('upload-form').style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Setup toggle functionality for each edit button and form
            const setupToggle = (editBtnId, formId) => {
                const editButton = document.getElementById(editBtnId);
                const form = document.getElementById(formId);
                if (editButton && form) {
                    editButton.addEventListener('click', function () {
                        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
                    });
                }
            };

            // Apply toggle setup for each section (like genre, tag, platform, developer)
            setupToggle('genre-edit', 'genre-form');
            setupToggle('tag-edit', 'tag-form');
            setupToggle('platform-edit', 'platform-form');
            setupToggle('developer-edit', 'developer-form');

            // Assuming you have a button to trigger edit mode (e.g. "Chỉnh sửa")
            const editButton = document.getElementById('edit-button'); // Add the correct ID for the edit button

            if (editButton) {
                editButton.addEventListener('click', enableEditMode);
            }
        });

        document.getElementById('screenshot-upload-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('action', 'uploadScreenshot');

            fetch('../../index.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Screenshot uploaded!");
                    location.reload(); // or append new image to the page
                } else {
                    alert("Upload failed: " + data.message);
                }
            })
            .catch(err => {
                console.error("Upload error:", err);
                alert("An error occurred during upload.");
            });
        });
        document.getElementById('saveButton').addEventListener('click', function () {
            const gameData = {
                action: 'saveEditedGame',
                name: document.getElementById('game-name').innerText,
                released: document.getElementById('game-released').innerText,
                price: document.getElementById('game-price').innerText,
                rating: document.getElementById('game-rating').innerText,
                meta: document.getElementById('game-meta').innerText,
                description: document.getElementById('game-description').innerText,
                id: <?= $game['id'] ?> // Assuming you're editing a specific game by ID
            };

            fetch('../../index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(gameData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Cập nhật thành công!");
                    location.reload(); // optional: refresh the page to reflect updated info
                } else {
                    alert("Cập nhật thất bại!");
                    console.error(data.message);
                }
            })
            .catch(error => {
                alert("Đã xảy ra lỗi.");
                console.error(error);
            });
        });



        // Show the upload form
        function showUploadForm() {
            document.getElementById('upload-form').style.display = 'block';
        }

        // Delete screenshot
        
        function deleteScreenshot(imgPath) {
            if (!confirm("Are you sure you want to delete this screenshot?")) return;

            fetch('../../index.php?action=deleteScreenshot"', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=deleteScreenshot&img_path=${encodeURIComponent(imgPath)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`button[data-img-path="${imgPath}"]`).closest('.screenshot-container').remove();
                    } else {
                        alert("Error deleting screenshot.");
                        console.error(data.error);
                    }
                })
                .catch(error => {
                    alert("Failed to send request.");
                    console.error("Error:", error);
                });
        }



    </script>
        

    


</body>