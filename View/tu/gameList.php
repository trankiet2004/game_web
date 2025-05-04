<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Game List</title>
    <style>
        .game {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>

<body>

    <h1>Game List</h1>

    <!-- Search and Sort Form -->
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

    <!-- Product List -->
    <div id="productList">
        <?php if (count($game) > 0): ?>
            <?php foreach ($game as $g): ?>
                <a class="card container" href="/game_web/index.php?action=game&id=<?= $g['id'] ?>">
                    <div class="game">
                        <h3><?= htmlspecialchars($g['name']) ?></h3>
                        <p>Released: <?= htmlspecialchars($g['released']) ?></p>
                        <p>Price: $<?= number_format($g['price'], 2) ?></p>
                        <p>Rating: <?= htmlspecialchars($g['rating']) ?></p>
                        <img src="<?= '/game_web/View/data/' . htmlspecialchars($g['background_image']) ?>"
                            alt="<?= htmlspecialchars($g['id']) ?>" style="width:200px;">
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No games found.</p>
        <?php endif; ?>
    </div>

    <!-- Load More Button -->
    <?php if ($total > $limit): ?>
        <button id="loadMoreBtn">Load More</button>
    <?php endif; ?>

    <!-- jQuery & AJAX script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                url: '/game_web/index.php', // same controller URL
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
                            // console.log("Appending game: ", g.name);
                            const html = `
                            <a class="card container" href="/game_web/index.php?action=game&id=${g.id}">
                                <div class="game">
                                    <h3>${g.name}</h3>
                                    <p>Released: ${g.released}</p>
                                    <p>Price: $${parseFloat(g.price).toFixed(2)}</p>
                                    <p>Rating: ${g.rating}</p>
                                    <img src="/game_web/View/data/${g.background_image}" alt="${g.id}" style="width:200px;">
                                </div>
                            </a>
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
    </script>
</body>

</html>