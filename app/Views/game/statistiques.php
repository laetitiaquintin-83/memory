<div class="stats-container">
    <h1>📊 Mes Statistiques</h1>
    <p class="subtitle">Bonjour <?= esc($user['login']) ?>, voici ton tableau de bord !</p>

    <!-- Cartes résumé -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon">🎮</div>
            <div class="stat-value"><?= $stats['total_parties'] ?? 0 ?></div>
            <div class="stat-label">Parties jouées</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⚡</div>
            <div class="stat-value"><?= $stats['meilleur_temps'] ?? '--:--' ?></div>
            <div class="stat-label">Meilleur temps</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⏱️</div>
            <div class="stat-value"><?= $stats['temps_moyen'] ? substr($stats['temps_moyen'], 0, 8) : '--:--' ?></div>
            <div class="stat-label">Temps moyen</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🏆</div>
            <div class="stat-value">#<?= $stats['rang'] ?? '-' ?></div>
            <div class="stat-label">Classement</div>
        </div>
    </div>

    <!-- Stats par niveau -->
    <?php if (!empty($stats['par_niveau'])): ?>
    <div class="stats-section">
        <h2>📈 Performance par niveau</h2>
        <div class="niveau-grid">
            <?php foreach ($stats['par_niveau'] as $niveau): ?>
                <div class="niveau-card">
                    <div class="niveau-header">
                        <?php
                        $niveauNom = match($niveau['nombre_paires']) {
                            3 => '🌱 Débutant',
                            6 => '🎯 Normal',
                            9 => '🔥 Difficile',
                            12 => '💀 Expert',
                            default => $niveau['nombre_paires'] . ' paires'
                        };
                        ?>
                        <span><?= $niveauNom ?></span>
                        <span class="niveau-paires"><?= $niveau['nombre_paires'] ?> paires</span>
                    </div>
                    <div class="niveau-stats">
                        <div class="niveau-stat">
                            <span class="label">Parties</span>
                            <span class="value"><?= $niveau['nb_parties'] ?></span>
                        </div>
                        <div class="niveau-stat">
                            <span class="label">Meilleur</span>
                            <span class="value"><?= $niveau['meilleur'] ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Historique des dernières parties -->
    <?php if (!empty($stats['dernieres_parties'])): ?>
    <div class="stats-section">
        <h2>🕐 Dernières parties</h2>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Paires</th>
                    <th>Temps</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats['dernieres_parties'] as $partie): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($partie['date_creation'])) ?></td>
                        <td>
                            <?php
                            $emoji = match($partie['nombre_paires']) {
                                3 => '🌱',
                                6 => '🎯',
                                9 => '🔥',
                                12 => '💀',
                                default => '🎮'
                            };
                            ?>
                            <?= $emoji ?> <?= $partie['nombre_paires'] ?> paires
                        </td>
                        <td><?= $partie['temps'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="stats-empty">
        <p>🎮 Tu n'as pas encore joué de parties !</p>
        <a href="/game" class="btn btn-play">Lancer une partie</a>
    </div>
    <?php endif; ?>

    <div class="stats-actions">
        <a href="/game" class="btn btn-primary">🎮 Jouer</a>
        <a href="/game/classement" class="btn btn-secondary">🏆 Classement</a>
    </div>
</div>
