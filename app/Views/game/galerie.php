<div class="galerie-container">
    <h1>🎴 Galerie des Cartes</h1>
    <p class="subtitle">Découvrez toutes les cartes du jeu Memory Medieval</p>

    <div class="galerie-grid">
        <?php foreach ($cartes as $carte): ?>
            <div class="galerie-card">
                <div class="card-image">
                    <img src="<?= $carte['image'] ?>" alt="<?= $carte['nom'] ?>">
                </div>
                <div class="card-label">
                    <span><?= $carte['nom'] ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="galerie-actions">
        <a href="/game" class="btn btn-primary">🎮 Jouer maintenant</a>
        <a href="/" class="btn btn-secondary">🏠 Retour à l'accueil</a>
    </div>
</div>
