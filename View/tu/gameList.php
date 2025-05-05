<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="./View/tu/">
    <title>Game List</title>
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
            margin-top: 30px;
        }

        #productList {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
            justify-items: center;
        }

        .game-card {
            background-color: #121212;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px #00ffcc33;
            transition: transform 0.3s, box-shadow 0.3s;
            width: 100%;
            max-width: 300px;
            text-decoration: none;
            color: white;
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px #00ffccb0;
        }

        .game-img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-bottom: 1px solid #444;
        }

        .game-info {
            padding: 15px;
        }

        .game-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #00ffcc;
        }

        .release-date,
        .price,
        .rating {
            font-size: 0.9rem;
            margin: 4px 0;
            color: #ccc;
        }

        form#searchForm {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px auto;
        }

        #loadMoreBtn {
            display: block;
            margin: 20px auto;
            background-color: #00ffcc;
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        #loadMoreBtn:hover {
            background-color: #00ccaa;
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

        form#searchForm input:focus,
        form#searchForm select:focus {
            box-shadow: 0 0 10px #00ffccaa;
            background-color: #22223b;
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
    </style>
</head>

<body>
    <div id="header"></div>

    <h1>Game List</h1>

    <form method="POST" id="searchForm">
        <input type="text" name="title" id="title" placeholder="Search by name" value="<?= htmlspecialchars($title) ?>">
        <select name="sort_by" id="sort_by" onchange="document.getElementById('searchForm').submit();">
            <option value="default" <?= $sort_by == 'default' ? 'selected' : '' ?>>Newest</option>
            <option value="oldest" <?= $sort_by == 'oldest' ? 'selected' : '' ?>>Oldest</option>
            <option value="highest_price" <?= $sort_by == 'highest_price' ? 'selected' : '' ?>>Highest Price</option>
            <option value="lowest_price" <?= $sort_by == 'lowest_price' ? 'selected' : '' ?>>Lowest Price</option>
            <option value="a_z" <?= $sort_by == 'a_z' ? 'selected' : '' ?>>A - Z</option>
            <option value="z_a" <?= $sort_by == 'z_a' ? 'selected' : '' ?>>Z - A</option>
            <option value="highrating" <?= $sort_by == 'highrating' ? 'selected' : '' ?>>Highest Rating</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <div id="productList">
        <?php if (count($game) > 0): ?>
            <?php foreach ($game as $g): ?>
                <a href="../../index.php?action=game&id=<?= $g['id'] ?>" class="game-card">
                    <img src="<?= '../../View/data/' . htmlspecialchars($g['background_image']) ?>" alt="<?= htmlspecialchars($g['id']) ?>" class="game-img">
                    <div class="game-info">
                        <h5 class="game-title"><?= htmlspecialchars($g['name']) ?></h5>
                        <p class="release-date">Released: <?= htmlspecialchars($g['released']) ?></p>
                        <p class="price">Price: $<?= number_format($g['price'], 2) ?></p>
                        <p class="rating">Rating: <?= htmlspecialchars($g['rating']) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">No games found.</p>
        <?php endif; ?>
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

        $('#loadMoreBtn').on('click', function () {
            currentPage++;
            if (currentPage > totalPages) {
                $('#loadMoreBtn').hide();
                return;
            }

            const title = $('#title').val();
            const sortBy = $('#sort_by').val();

            $.ajax({
                url: '../../index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'load_products',
                    title: title,
                    sort_by: sortBy,
                    page_num: currentPage
                },
                success: function (response) {
                    if (response.status === 'success') {
                        let games = response.data;
                        if (games.length === 0) {
                            $('#loadMoreBtn').hide();
                        }

                        games.forEach(g => {
                            const html = `
                                <div class="game-card">
                                    <img src="../../View/data/${g.background_image}" alt="${g.id}" class="game-img">
                                    <div class="game-info">
                                        <h5 class="game-title">${g.name}</h5>
                                        <p class="release-date">Released: ${g.released}</p>
                                        <p class="price">Price: $${parseFloat(g.price).toFixed(2)}</p>
                                        <p class="rating">Rating: ${g.rating}</p>
                                    </div>
                                </div>
                            `;
                            $('#productList').append(html);
                        });

                        if (currentPage >= totalPages) {
                            $('#loadMoreBtn').hide();
                        }
                    } else {
                        alert("No more games to load.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", error);
                }
            });
        });

        // Load header and footer components
        document.addEventListener("DOMContentLoaded", function () {
            fetch('../component/header.php')
                .then(r => r.text())
                .then(html => {
                    document.getElementById("header").innerHTML = html;

                    // 🔥 Re-initialize Bootstrap dropdown
                    document.querySelectorAll('.dropdown-toggle').forEach(function (dropdownToggleEl) {
                        new bootstrap.Dropdown(dropdownToggleEl);
                    });
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
