<h1><?= htmlspecialchars($tags['name']) ?></h1>
<img src="/game_web/View/data/<?= htmlspecialchars($tags['background_image']) ?>" alt="<?= htmlspecialchars($tags['name']) ?>" width="300">
<p><strong>Game Count:</strong> <?= $tags['game_count'] ?></p>

<!-- Games Container -->
<div id="game-list">
    <?php foreach ($tags['games'] as $game): ?>
        <a href="/game_web/index.php?action=game&id=<?= $game['id'] ?>" class="game-card-link">
            <div class="game-card">
                <h3><?= htmlspecialchars($game['name']) ?></h3>
                <img src="/game_web/View/data/<?= htmlspecialchars($game['background_image']) ?>" alt="<?= htmlspecialchars($game['name']) ?>" width="200">
                <p>Released: <?= $game['released'] ?></p>
                <p>Price: <?= $game['price'] ?></p>
                <p>Rating: <?= $game['rating'] ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>


<!-- Load More Button -->
<?php if ($total_games > 12): ?>
    <button id="loadMoreBtn" data-page="1" data-id="<?= $tags['id'] ?>">Load More</button>
<?php endif; ?>

<!-- JavaScript for AJAX -->
<script>
document.getElementById("loadMoreBtn").addEventListener("click", function () {
    const button = this;
    const page = parseInt(button.dataset.page) + 1;
    const id = button.dataset.id;

    fetch("/game_web/index.php?action=load_more_games_in_tags", {
        method: "POST",
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=load_more_games_in_tags&id=${id}&page=${page}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            const container = document.getElementById("game-list");
            data.games.forEach(game => {
                const div = document.createElement("div");
                div.classList.add("game-card");
                div.innerHTML = `
                    <h3>${game.name}</h3>
                    <img src="/game_web/View/data/${game.background_image}" width="200">
                    <p>Released: ${game.released}</p>
                    <p>Price: ${game.price}</p>
                    <p>Rating: ${game.rating}</p>
                `;
                container.appendChild(div);
            });

            button.dataset.page = page;

            if (page * 12 >= data.total) {
                button.remove(); // Remove button if no more games
            }
        }
    });
});
</script>
