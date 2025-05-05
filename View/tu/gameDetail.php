<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="./View/tu/">
    <title><?= htmlspecialchars($game['name']) ?> - Game Details</title>
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

        .game-detail-container {
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

        .game-detail-container img.cover {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .screenshots img {
            max-width: 100%;
            margin-top: 1rem;
            border-radius: 10px;
            box-shadow: 0 0 10px #00ffcc33;
        }

        .meta-section a {
            color: #00ffcc;
            text-decoration: none;
        }

        .meta-section a:hover {
            text-decoration: underline;
        }

        ul {
            padding-left: 1.5rem;
        }

        #header, #footer {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div id="header"></div>

    <div class="game-detail-container">
        <a class="back-link" href="../../index.php?action=game">&larr; Back to Game List</a>

        <h1><?= htmlspecialchars($game['name']) ?></h1>
        <img src="../../View/data/<?= htmlspecialchars($game['background_image']) ?>" alt="<?= htmlspecialchars($game['name']) ?>" class="cover">

        <div class="meta-section">
            <p><strong>Released:</strong> <?= htmlspecialchars($game['released']) ?></p>
            <p><strong>Price:</strong> $<?= number_format($game['price'], 2) ?></p>
            <p><strong>Rating:</strong> <?= htmlspecialchars($game['rating']) ?></p>
            <p><strong>Description:</strong><br>
                <?= nl2br(htmlspecialchars($game['description'] ?? 'No description available.')) ?></p>

            <p><strong>Genres:</strong>
                <?php foreach ($game['genres'] as $index => $genre): ?>
                    <a href="../../index.php?action=genres&id=<?= $genre['id'] ?>">
                        <?= htmlspecialchars($genre['name']) ?>
                    </a><?= $index < count($game['genres']) - 1 ? ', ' : '' ?>
                <?php endforeach; ?>
            </p>

            <p><strong>Tags:</strong>
                <?php foreach ($game['tags'] as $index => $tag): ?>
                    <a href="../../index.php?action=tag&id=<?= $tag['id'] ?>">
                        <?= htmlspecialchars($tag['name']) ?>
                    </a><?= $index < count($game['tags']) - 1 ? ', ' : '' ?>
                <?php endforeach; ?>
            </p>

            <p><strong>Platforms:</strong>
                <?php foreach ($game['platforms'] as $index => $platform): ?>
                    <a href="../../index.php?action=platform&id=<?= $platform['id'] ?>">
                        <?= htmlspecialchars($platform['name']) ?>
                    </a><?= $index < count($game['platforms']) - 1 ? ', ' : '' ?>
                <?php endforeach; ?>
            </p>

            <p><strong>Developers:</strong>
                <?php foreach ($game['developers'] as $index => $dev): ?>
                    <?= htmlspecialchars($dev['name']) ?><?= $index < count($game['developers']) - 1 ? ', ' : '' ?>
                <?php endforeach; ?>
            </p>

            <?php if (!empty($game['ratings'])):
                $rating = $game['ratings'][0]; ?>
                <p><strong>User Ratings:</strong></p>
                <ul>
                    <li>Exceptional: <?= (int) $rating['exceptional'] ?></li>
                    <li>Recommended: <?= (int) $rating['recommended'] ?></li>
                    <li>Meh: <?= (int) $rating['meh'] ?></li>
                    <li>Skip: <?= (int) $rating['skip'] ?></li>
                </ul>
            <?php else: ?>
                <p><strong>User Ratings:</strong> No ratings yet.</p>
            <?php endif; ?>
        </div>

        <div class="screenshots">
            <h3>Screenshots:</h3>
            <?php foreach ($game['screenshots'] as $shot): ?>
                <img src="../../View/data/<?= htmlspecialchars($shot['img_path']) ?>" alt="Screenshot">
            <?php endforeach; ?>
        </div>
    </div>

    <footer id="footer" class="cyber-footer py-5"></footer>

    <script>
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
