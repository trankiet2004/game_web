<!-- View/tu/gameDetail.php -->
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
    </style>
</head>
<body>

<div class="game-detail-container">
    <a class="back-link" href="/game_web/">← Back to Game List</a>

    <h1><?= htmlspecialchars($game['name']) ?></h1>
    <img src="/game_web/View/data/<?= htmlspecialchars($game['background_image']) ?>" alt="<?= htmlspecialchars($game['name']) ?>">
    
    <p><strong>Released:</strong> <?= htmlspecialchars($game['released']) ?></p>
    <p><strong>Price:</strong> $<?= number_format($game['price'], 2) ?></p>
    <p><strong>Rating:</strong> <?= htmlspecialchars($game['rating']) ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($game['description'] ?? 'No description available.')) ?></p>
</div>

</body>
</html>
