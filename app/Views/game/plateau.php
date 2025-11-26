<?php
$maintenant = time();
$debut = $_SESSION['debut_partie'] ?? $maintenant;
$tempsEcoule = $maintenant - $debut;

$chronoAffiche = gmdate("i:s", $tempsEcoule);

// Déterminer la classe de grille selon le nombre de cartes
$nbCartes = count($jeu);
if ($nbCartes <= 6) {
    $classeGrille = 'grille-3'; // 3 colonnes pour 6 cartes (3 paires)
} elseif ($nbCartes <= 12) {
    $classeGrille = 'grille-4'; // 4 colonnes pour 12 cartes (6 paires)
} elseif ($nbCartes <= 18) {
    $classeGrille = 'grille-6'; // 6 colonnes pour 18 cartes (9 paires)
} else {
    $classeGrille = 'grille-6'; // 6 colonnes pour 24 cartes (12 paires)
}
?>

<div class="game-container">

<div class="info-bar">
    <a href="/game" class="btn-abandon">Abandonner</a>

    <div class="timer-box">
       <span>Temps :</span>
       <span style="font-family: monospace; font-size: 1.2em;">
        <?= $chronoAffiche ?>
</span>
</div>
</div>

<div id="plateau-jeu" class="<?= $classeGrille ?>">
    <?php
    for ($i = 0; $i < count($jeu); $i++){
        $carte = $jeu[$i];
        $classeSpeciale = $carte->getEstTrouvee() ? 'trouvee' : "";
        ?>

        <div class="carte-conteneur <?= $classeSpeciale ?>">
        <?php if ($carte->getEstRetournee() || $carte->getEstTrouvee()): ?>
                    <img src="<?= $carte->getImage() ?>" alt="Carte Memory" class="carte-img">
                
                <?php else: ?>
                    <a href="/game/play?i=<?= $i ?>" style="display:block; width:100%; height:100%; text-decoration:none;">
                        <img src="/assets/images/cards/dos.jpg" alt="dos de carte" class="carte-img">
                    </a>
                <?php endif; ?>

            </div>

        <?php 
        } // Fin de la boucle for
        ?>
    </div>
    
        