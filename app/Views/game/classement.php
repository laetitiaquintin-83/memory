<div class="classement-container">
    <h1>🏆 Meilleurs scores</h1>

    <?php if (empty($scores)): ?>
        <p class="no-scores">Aucun score enregistré pour le moment.</p>
        <div class="actions">
            <a href="/game" class="btn btn-primary">Jouer une partie</a>
        </div>
    <?php else: ?>
        <table class="scores-table">
            <thead>
                <tr>
                    <th>Rang</th>
                    <th>Joueur</th>
                    <th>Temps</th>
                    <th>Paires</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $index => $score): ?>
                    <tr>
                        <td class="rang">
                            <?php
                            $rang = $index + 1;
                            if ($rang === 1) echo '🥇';
                            elseif ($rang === 2) echo '🥈';
                            elseif ($rang === 3) echo '🥉';
                            else echo $rang;
                            ?>
                        </td>
                        <td class="joueur"><?= esc($score['login']) ?></td>
                        <td class="temps"><?= esc($score['temps']) ?></td>
                        <td class="paires"><?= esc($score['nombre_paires']) ?> paires</td>
                        <td class="date"><?= format_date($score['date_creation']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="actions">
            <a href="/game" class="btn btn-primary">Nouvelle partie</a>
        </div>
    <?php endif; ?>
</div>
