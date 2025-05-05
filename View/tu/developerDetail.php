<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="./View/tu/">
    <title><?= htmlspecialchars($developers['name']) ?> - Developer Details</title>
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

        .developer-detail-container {
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

        .developer-img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .game-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 2rem;
        }

        .game-card {
            background-color: #1e1e2f;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 0 10px #00ffcc33;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px #00ffccb0;
        }

        .game-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .game-card h3 {
            font-size: 1.1rem;
            color: #00ffcc;
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

    <div class="developer-detail-container">
        <a class="back-link" href="../../index.php?action=developer">&larr; Back to Developer List</a>

        <h1><?= htmlspecialchars($developers['name']) ?></h1>
        <img src="../../View/data/<?= htmlspecialchars($developers['background_image']) ?>" alt="<?= htmlspecialchars($developers['name']) ?>" class="developer-img">
        <p><strong>Game Count:</strong> <?= $total_games ?></p>

        <div id="game-list" class="game-list">
            <?php foreach ($developers['games'] as $game): ?>
                <a href="../../index.php?action=game&id=<?= $game['id'] ?>" class="game-card-link">
                    <div class="game-card">
                        <img src="../../View/data/<?= htmlspecialchars($game['background_image']) ?>" alt="<?= htmlspecialchars($game['name']) ?>">
                        <h3><?= htmlspecialchars($game['name']) ?></h3>
                        <p>Released: <?= $game['released'] ?></p>
                        <p>Price: $<?= number_format($game['price'], 2) ?></p>
                        <p>Rating: <?= $game['rating'] ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($total_games > 12): ?>
            <button id="loadMoreBtn" data-page="1" data-id="<?= $developers['id'] ?>">Load More</button>
        <?php endif; ?>
    </div>

    <footer id="footer" class="cyber-footer py-5"></footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById("loadMoreBtn")?.addEventListener("click", function () {
            const button = this;
            const page = parseInt(button.dataset.page) + 1;
            const id = button.dataset.id;

            fetch("../../index.php?action=load_more_games_in_developers", {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=load_more_games_in_developers&id=${id}&page=${page}`
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        const container = document.getElementById("game-list");
                        data.games.forEach(game => {
                            const div = document.createElement("div");
                            div.classList.add("game-card");
                            div.innerHTML = `
                                <img src="../../View/data/${game.background_image}" alt="${game.name}">
                                <h3>${game.name}</h3>
                                <p>Released: ${game.released}</p>
                                <p>Price: $${parseFloat(game.price).toFixed(2)}</p>
                                <p>Rating: ${game.rating}</p>
                            `;
                            container.appendChild(div);
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>