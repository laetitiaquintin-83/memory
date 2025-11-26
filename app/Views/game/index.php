<div class="home-container">
    <h1>🏰 Memory</h1>
    <p class="subtitle">Prêt à tester votre mémoire ?</p>

    <form action="/game" method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="form-group">
            <label for="nb_paires">Niveau de difficulté :</label>
            <select name="nombre_paires" id="nb_paires">
                <option value="3">Débutant (3 paires - 6 cartes)</option>
                <option value="6" selected>Normal (6 paires - 12 cartes)</option>
                <option value="9">Difficile (9 paires - 18 cartes)</option>
                <option value="12">Expert (12 paires - 24 cartes)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-play">Lancer la partie</button>
    </form>

    <a href="/game/classement" class="btn-classement">Voir les meilleurs scores</a>
</div>
