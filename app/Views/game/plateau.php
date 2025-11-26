<?php
$maintenant = time();
$debut = $_SESSION['debut_partie'] ?? $maintenant;
$tempsEcoule = $maintenant - $debut;

$chronoAffiche = gmdate("i:s", $tempsEcoule);
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

<div id="plateau-jeu">
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
                        <div class="dos"></div>
                    </a>
                <?php endif; ?>

            </div>

        <?php 
        } // Fin de la boucle for
        ?>
    </div>
    
        