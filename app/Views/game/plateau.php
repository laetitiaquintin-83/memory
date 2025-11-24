<?php

for ($i = 0;  $i < count($jeu); $i++) {

    $carte = $jeu[$i];
    ?>

    <div class="carte-conteneur">

    <?php if ($carte->getEstRetournee()): ?>
        <img src="<?= $carte->getImage() ?>" alt ="Image du memory">

        <?php else: ?>
            <a href="/game/play?i=<?= $i ?>">
                <div class="dos"></div>
        </a>
        <?php endif; ?>

        </div>

        <?php
       
}
?>
</div>