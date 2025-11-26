<?php
// Calculer le nombre d'étoiles basé sur la performance
// Convertir le temps en secondes
$timeParts = explode(':', $temps);
$totalSeconds = (int)$timeParts[0] * 3600 + (int)$timeParts[1] * 60 + (int)$timeParts[2];

// Temps cible selon le nombre de paires
$tempsParfait = $paires * 10; // 10 secondes par paire = parfait
$tempsBien = $paires * 20;    // 20 secondes par paire = bien

if ($totalSeconds <= $tempsParfait) {
    $etoiles = 3;
    $message = "Performance exceptionnelle !";
} elseif ($totalSeconds <= $tempsBien) {
    $etoiles = 2;
    $message = "Très bonne performance !";
} else {
    $etoiles = 1;
    $message = "Partie terminée !";
}
?>

<div class="bravo-container">
    <span class="felicitation">🏆</span>

    <h1>Félicitations !</h1>
    
    <div class="stars-container">
        <div class="stars">
            <span class="star <?= $etoiles >= 1 ? 'active' : '' ?>">⭐</span>
            <span class="star <?= $etoiles >= 2 ? 'active' : '' ?>">⭐</span>
            <span class="star <?= $etoiles >= 3 ? 'active' : '' ?>">⭐</span>
        </div>
        <p class="performance-text"><?= $message ?></p>
    </div>

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