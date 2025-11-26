<div class="bravo-container">
    <span class="felicitation">🏆</span>

    <h1>Félicitations !</h1>
    <p>Vous avez trouvé toutes les paires. Le memory n'a plus de secrets pour vous !</p>

    <div class="score-box">
        <p>Temps réalisé : <strong><?= $temps ?></strong></p>
        <p>Nombre de paires : <strong><?= $paires ?></strong></p>
    </div>

    <div class="actions">
        <a href="/game" class="btn btn-replay">Rejouer</a>
        <a href="/game/classement" class="btn btn-secondary">Voir le classement</a>
    </div>
</div>