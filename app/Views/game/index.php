<!-- Cartes flottantes en arrière-plan -->
<div class="floating-cards">
    <div class="floating-card" style="--delay: 0s; --x: 10%;"><img src="/assets/images/cards/1.jpg" alt=""></div>
    <div class="floating-card" style="--delay: 2s; --x: 25%;"><img src="/assets/images/cards/3.jpg" alt=""></div>
    <div class="floating-card" style="--delay: 4s; --x: 40%;"><img src="/assets/images/cards/5.jpg" alt=""></div>
    <div class="floating-card" style="--delay: 1s; --x: 55%;"><img src="/assets/images/cards/7.jpg" alt=""></div>
    <div class="floating-card" style="--delay: 3s; --x: 70%;"><img src="/assets/images/cards/9.jpg" alt=""></div>
    <div class="floating-card" style="--delay: 5s; --x: 85%;"><img src="/assets/images/cards/11.jpg" alt=""></div>
</div>

<div class="home-container">
    <h1>🌀 Monde Parallèle</h1>
    <p class="subtitle">Prêt à tester votre mémoire ?</p>

    <form action="/game" method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="form-group">
            <label for="theme">Choisissez un thème :</label>
            <select name="theme" id="theme" onchange="changeTheme(this.value)">
                <option value="princesse" selected>👸 Princesse</option>
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
    document.body.classList.remove('theme-medieval', 'theme-princesse', 'theme-disney', 'theme-bisounours', 'theme-winnie', 'theme-poney', 'theme-hellokitty', 'theme-mario');
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
    
    // Mettre à jour les cartes flottantes
    updateFloatingCards(theme);
}

function updateFloatingCards(theme) {
    const offsets = {
        princesse: 0, disney: 12, bisounours: 24, winnie: 36,
        poney: 48, hellokitty: 60, mario: 74
    };
    const offset = offsets[theme] || 0;
    const cardNums = [1, 3, 5, 7, 9, 11];
    const floatingCards = document.querySelectorAll('.floating-card img');
    floatingCards.forEach((card, i) => {
        card.src = `/assets/images/cards/${offset + cardNums[i]}.jpg`;
    });
}

// Appliquer le thème par défaut au chargement
document.addEventListener('DOMContentLoaded', function() {
    changeTheme('princesse');
});
</script>
