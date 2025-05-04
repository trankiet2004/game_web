<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Platform List</title>
    <style>
        /* Styling for the platform list */
        .platform-container {
            max-width: 1200px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .platform-card {
            border: 1px solid #ccc;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .card.container {
            display: block;
            width: 250px;
            padding: 16px;
            margin: 12px;
            border-radius: 12px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: #333;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card.container:hover {
            transform: translateY(-4px);

            box-shadow: 0 6px 16px rgba(0, 0, 0 .card-container img {
                    width: 100%;
                    border-radius: 8px;
                    height: auto;
                }

                .platform-card h3 {
                    font-size: 1.5rem;
                    margin: 1rem 0;
                }

                .platform-card p {
                    margin: 0.5rem 0;
                }

                .pagination {
                    text-align: center;
                    margin-top: 20px;
                }

                .pagination a {
                    padding: 0.5rem 1rem;
                    text-decoration: none;
                    background-color: #007bff;
                    color: #fff;
                    border-radius: 4px;
                    margin: 0 5px;
                }

                .pagination a:hover {
                    background-color: #0056b3;
                }
    </style>
</head>

<body>

    <h1>Platform List</h1>

    <!-- Search and Sort -->
    <div class="filter-container">
        <!-- Title Filter -->
        <input type="text" id="title" name="title" placeholder="Search for platforms...">

        <!-- Sort By Dropdown -->
        <select id="sort_by" name="sort_by">
            <option value="a-z">A-Z</option>
            <option value="z-a">Z-A</option>
        </select>
    </div>

    <!-- Platform List Container -->
    <div id="platformList" class="platform-list">
        <?php if (count($platforms) > 0): ?>
            <?php foreach ($platforms as $g): ?>
                <a class="card container" href="/game_web/index.php?action=platform&id=<?= $g['id'] ?>">
                    <div class="platform">
                        <h3><?= htmlspecialchars($g['name']) ?></h3>
                        <p>Game count: <?= $g['game_count'] ?></p>
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
    <button id="loadMoreBtn">Load More</button>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentPage = 1;
        const totalPages = <?= ceil($total / $limit) ?>;

        function loadPlatforms(page = 1, append = false) {
            const title = $('#title').val();
            const sortBy = $('#sort_by').val();

            $.ajax({
                url: '/game_web/index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'load_platforms',
                    title: title,
                    sort_by: sortBy,
                    page_num: page
                },
                success: function (response) {
                    if (response.status === 'success') {
                        let platforms = response.data;

                        if (!append) {
                            $('#platformList').empty(); // Clear previous list if not appending
                        }

                        platforms.forEach(p => {
                            const html = `
                                <a class="card container" href="/game_web/index.php?action=platform&id=${p.id}">
                                <div class="platform">
                                    <h3>${p.name}</h3>
                                    <p>Game count: ${p.game_count}</p>
                                    <img src="/game_web/View/data/${p.background_image}" alt="${p.name}" style="width:200px;">
                                </div>
                                </a>
                            `;
                            $('#platformList').append(html);
                        });


                        if (page >= response.total_pages || platforms.length === 0) {
                            $('#loadMoreBtn').hide();
                        } else {
                            $('#loadMoreBtn').show();
                        }
                    } else {
                        alert("No more platforms to load.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", error);
                }
            });
        }

        // Initial load already handled by PHP; only needed for filter or sort change
        $('#title, #sort_by').on('change keyup', function () {
            currentPage = 1;
            loadPlatforms(currentPage, false); // false means reset, not append
        });

        $('#loadMoreBtn').on('click', function () {
            currentPage++;
            loadPlatforms(currentPage, true); // true means append results
        });
    </script>



</body>

</html>