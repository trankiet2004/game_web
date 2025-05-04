<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($game['name']) ?> - Game Details</title>
    <style>
        .game-detail-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-family: Arial, sans-serif;
        }

        .game-detail-container img {
            max-width: 100%;
            border-radius: 8px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .meta-section {
            margin-top: 1rem;
        }

        .meta-section strong {
            display: inline-block;
            min-width: 100px;
        }

        .screenshots img {
            max-width: 100%;
            margin-top: 1rem;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="game-detail-container">
        <a class="back-link" href="/game_web/index.php">← Back to Game List</a>

        <h1><?= htmlspecialchars($game['name']) ?></h1>
        <img src="/game_web/View/data/<?= htmlspecialchars($game['background_image']) ?>"
            alt="<?= htmlspecialchars($game['name']) ?>">

        <div class="meta-section">
            <p><strong>Released:</strong> <?= htmlspecialchars($game['released']) ?></p>
            <p><strong>Price:</strong> $<?= number_format($game['price'], 2) ?></p>
            <p><strong>Rating:</strong> <?= htmlspecialchars($game['rating']) ?></p>
            <p><strong>Description:</strong>
                <?= nl2br(htmlspecialchars($game['description'] ?? 'No description available.')) ?></p>

            <p><strong>Genres:</strong>
                <?php foreach ($game['genres'] as $index => $genre): ?>
                    <a href="/game_web/index.php?action=genres&id=<?= $genre['id'] ?>">
                        <?= htmlspecialchars($genre['name']) ?>
                    </a>
                    <?php if ($index < count($game['genres']) - 1): ?> <!-- If it's not the last genre -->
                        ,
                    <?php endif; ?>
                <?php endforeach; ?>
            </p>


            <p><strong>Tags:</strong>
                <?php foreach ($game['tags'] as $index => $tag): ?>
                    <a href="/game_web/index.php?action=tag&id=<?= $tag['id'] ?>">
                        <?= htmlspecialchars($tag['name']) ?>
                    </a><?= $index < count($game['tags']) - 1 ? ', ' : '' ?>
                <?php endforeach; ?>
            </p>



            <p><strong>Platforms:</strong>
                <?php foreach ($game['platforms'] as $index => $platform): ?>
                    <a href="/game_web/index.php?action=platform&id=<?= $platform['id'] ?>">
                        <?= htmlspecialchars($platform['name']) ?>
                    </a><?= $index < count($game['platforms']) - 1 ? ', ' : '' ?>
                <?php endforeach; ?>
            </p>


            <p><strong>Developers:</strong>
                <?php foreach ($game['developers'] as $dev): ?>
                    <?= htmlspecialchars($dev['name']) ?>
                    <?= !$loopEnded = (next($game['developers']) === false) ? '' : ', ' ?>
                <?php endforeach; ?>
            </p>


            <?php if (!empty($game['ratings'])):
                $rating = $game['ratings'][0]; // only one row expected due to primary key on game_id
                ?>
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

            </p>
        </div>

        <div class="screenshots">
            <h3>Screenshots:</h3>
            <?php foreach ($game['screenshots'] as $shot): ?>
                <img src="/game_web/View/data/<?= htmlspecialchars($shot['img_path']) ?>" alt="Screenshot">
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>