<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="./View/tu/">
    <title><?= htmlspecialchars($platform['name']) ?> - Platform Details</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../component/header.css">
    <link rel="stylesheet" href="../component/footer.css">
    <style>
        body {
            background-color: #0f0f1a;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }

        .platform-detail-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #121212;
            border-radius: 15px;
            box-shadow: 0 0 20px #00ffcc44;
        }

        .back-link {
            color: #00ffcc;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        h1 {
            color: #00ffcc;
            margin-top: 1rem;
        }

        .meta-section p {
            margin: 0.5rem 0;
            font-size: 1rem;
        }

        .meta-section strong {
            color: #00e6b2;
            width: 120px;
            display: inline-block;
        }

        .platform-detail-container img.cover {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .game-card {
            background-color: #1a1a2e;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 0 10px #00ffcc33;
            text-align: center;
            color: white;
        }

        .game-card img {
            border-radius: 8px;
            width: 100%;
            height: auto;
            margin-bottom: 0.5rem;
        }

        .game-card h3 {
            color: #00ffcc;
        }

        .game-card a {
            text-decoration: none;
            color: inherit;
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
    </style>
</head>

<body>
<div id="header"></div>

<div class="platform-detail-container">
    <a class="back-link" href="../../index.php?action=platform">&larr; Back to Platform List</a>

    <h1><?= htmlspecialchars($platform['name']) ?></h1>
    <img src="../../View/data/<?= htmlspecialchars($platform['background_image']) ?>" alt="<?= htmlspecialchars($platform['name']) ?>" class="cover">
    <div class="meta-section">
        <p><strong>Game Count:</strong> <?= $platform['game_count'] ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($platform['description']) ?></p>
    </div>

    <div id="game-list">
        <?php foreach ($platform['games'] as $game): ?>
            <a href="../../index.php?action=game&id=<?= $game['id'] ?>" class="game-card-link">
                <div class="game-card">
                    <h3><?= htmlspecialchars($game['name']) ?></h3>
                    <img src="../../View/data/<?= htmlspecialchars($game['background_image']) ?>" alt="<?= htmlspecialchars($game['name']) ?>">
                    <p>Released: <?= $game['released'] ?></p>
                    <p>Price: <?= $game['price'] ?></p>
                    <p>Rating: <?= $game['rating'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($platform['game_count'] > 12): ?>
        <button id="loadMoreBtn" data-page="1" data-id="<?= $platform['id'] ?>">Load More</button>
    <?php endif; ?>
</div>

<footer id="footer" class="cyber-footer py-5"></footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById("loadMoreBtn")?.addEventListener("click", function () {
        const button = this;
        const page = parseInt(button.dataset.page) + 1;
        const id = button.dataset.id;

        fetch("../../index.php?action=load_more_games", {
            method: "POST",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=load_more_games&id=${id}&page=${page}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                const container = document.getElementById("game-list");
                data.games.forEach(game => {
                    const html = `
                        <a href="../../index.php?action=game&id=${game.id}" class="game-card-link">
                            <div class="game-card">
                                <h3>${game.name}</h3>
                                <img src="../../View/data/${game.background_image}" alt="${game.name}">
                                <p>Released: ${game.released}</p>
                                <p>Price: ${game.price}</p>
                                <p>Rating: ${game.rating}</p>
                            </div>
                        </a>`;
                    container.insertAdjacentHTML('beforeend', html);
                });
                button.dataset.page = page;
                if (page * 12 >= data.total) button.remove();
            }
        });
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