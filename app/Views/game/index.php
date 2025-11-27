<div class="home-container">
    <h1>🌀 Monde Parallèle</h1>
    <p class="subtitle">Prêt à tester votre mémoire ?</p>

    <form action="/game" method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="form-group">
            <label for="theme">Choisissez un thème :</label>
            <select name="theme" id="theme" onchange="changeTheme(this.value)">
                <option value="medieval" selected>👸 Princesse</option>
                <option value="disney">🐭 Amis de Mickey</option>
                <option value="bisounours">🐻 Bisounours</option>
                <option value="winnie">🍯 Winnie</option>
                <option value="poney">🦄 Petit Poney</option>
                <option value="hellokitty">🎀 Hello Kitty</option>
                <option value="mario">🍄 Mario</option>
            </select>
        </div>

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

<script>
function changeTheme(theme) {
    document.body.classList.remove('theme-medieval', 'theme-disney', 'theme-bisounours', 'theme-winnie', 'theme-poney', 'theme-hellokitty', 'theme-mario');
    document.body.classList.add('theme-' + theme);
    
    // Changer aussi le titre
    const h1 = document.querySelector('.home-container h1');
    if (theme === 'disney') {
        h1.textContent = '🐭 Monde Parallèle - Amis de Mickey';
    } else if (theme === 'bisounours') {
        h1.textContent = '🐻 Monde Parallèle - Bisounours';
    } else if (theme === 'winnie') {
        h1.textContent = '🍯 Monde Parallèle - Winnie';
    } else if (theme === 'poney') {
        h1.textContent = '🦄 Monde Parallèle - Petit Poney';
    } else if (theme === 'hellokitty') {
        h1.textContent = '🎀 Monde Parallèle - Hello Kitty';
    } else if (theme === 'mario') {
        h1.textContent = '🍄 Monde Parallèle - Mario';
    } else {
        h1.textContent = '👸 Monde Parallèle - Princesse';
    }
}
</script>
