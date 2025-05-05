<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="./View/tu/">
    <title>Tag List</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../component/header.css">
    <link rel="stylesheet" href="../component/footer.css">
    <style>
        body {
            background-color: #0f0f1a;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            color: white;
        }

        h1 {
            text-align: center;
            color: #00ffcc;
            margin: 30px 0;
        }

        form#searchForm {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px auto;
        }

        form#searchForm input,
        form#searchForm select {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            background-color: #1a1a2e;
            color: white;
            font-size: 1rem;
            outline: none;
            box-shadow: 0 0 5px #00ffcc66;
            transition: all 0.2s ease-in-out;
        }

        form#searchForm button {
            padding: 8px 16px;
            background-color: #00ffcc;
            color: black;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 0 8px #00ffcc88;
            transition: all 0.3s ease-in-out;
        }

        form#searchForm button:hover {
            background-color: #00e6b2;
            box-shadow: 0 0 12px #00ffcccc;
        }

        #tagList {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px 40px;
            justify-items: center;
        }

        .tag-card {
            background-color: #121212;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px #00ffcc33;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: white;
            max-width: 300px;
            width: 100%;
        }

        .tag-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px #00ffccb0;
        }

        .tag-img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-bottom: 1px solid #444;
        }

        .tag-info {
            padding: 15px;
        }

        .tag-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #00ffcc;
            margin-bottom: 8px;
        }

        .game-count {
            font-size: 0.95rem;
            color: #ccc;
        }

        #loadMoreBtn {
            display: block;
            margin: 20px auto;
            background-color: #00ffcc;
            color: black;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        #loadMoreBtn:hover {
            background-color: #00ccaa;
        }

        #footer {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div id="header"></div>

    <h1>Tag List</h1>

    <form id="searchForm">
        <input type="text" id="title" name="title" placeholder="Search for tags...">
        <select id="sort_by" name="sort_by">
            <option value="a-z">A-Z</option>
            <option value="z-a">Z-A</option>
        </select>
        <button type="button" onclick="loadTags(1, false)">Search</button>
    </form>

    <div id="tagList">
        <?php foreach ($tags as $g): ?>
            <a class="tag-card" href="../../index.php?action=tag&id=<?= $g['id'] ?>">
                <img src="<?= '../../View/data/' . htmlspecialchars($g['background_image']) ?>" class="tag-img" alt="<?= htmlspecialchars($g['name']) ?>">
                <div class="tag-info">
                    <div class="tag-title"><?= htmlspecialchars($g['name']) ?></div>
                    <div class="game-count">Game count: <?= $g['game_count'] ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($total > $limit): ?>
        <button id="loadMoreBtn">Load More</button>
    <?php endif; ?>

    <footer id="footer" class="cyber-footer py-5"></footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPage = 1;
        const totalPages = <?= ceil($total / $limit) ?>;

        function loadTags(page = 1, append = false) {
            const title = $('#title').val();
            const sortBy = $('#sort_by').val();

            $.ajax({
                url: '../../index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'load_tags',
                    title: title,
                    sort_by: sortBy,
                    page_num: page
                },
                success: function (response) {
                    if (response.status === 'success') {
                        const tags = response.data;

                        if (!append) $('#tagList').empty();

                        tags.forEach(p => {
                            const html = `
                                <a class="tag-card" href="../../index.php?action=tag&id=${p.id}">
                                    <img src="../../View/data/${p.background_image}" class="tag-img" alt="${p.name}">
                                    <div class="tag-info">
                                        <div class="tag-title">${p.name}</div>
                                        <div class="game-count">Game count: ${p.game_count}</div>
                                    </div>
                                </a>`;
                            $('#tagList').append(html);
                        });

                        if (page >= response.total_pages || tags.length === 0) $('#loadMoreBtn').hide();
                        else $('#loadMoreBtn').show();
                    } else {
                        alert("No more tags to load.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", error);
                }
            });
        }

        $('#title, #sort_by').on('input change', function () {
            currentPage = 1;
            loadTags(currentPage, false);
        });

        $('#loadMoreBtn').on('click', function () {
            currentPage++;
            loadTags(currentPage, true);
        });

        document.addEventListener("DOMContentLoaded", function () {
            fetch('../component/header.php')
                .then(r => r.text())
                .then(html => {
                    document.getElementById("header").innerHTML = html;
                    document.querySelectorAll('.dropdown-toggle').forEach(el => new bootstrap.Dropdown(el));
                });

            fetch('../component/footer.php')
                .then(r => r.text())
                .then(html => {
                    document.getElementById("footer").innerHTML = html;
                });
        });
    </script>
</body>

</html>
