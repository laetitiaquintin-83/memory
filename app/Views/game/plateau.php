<?php
$maintenant = time();
$debut = $_SESSION['debut_partie'] ?? $maintenant;
$tempsEcoule = $maintenant - $debut;

$chronoAffiche = gmdate("i:s", $tempsEcoule);

// Déterminer la classe de grille selon le nombre de cartes
$nbCartes = count($jeu);
if ($nbCartes <= 6) {
    $classeGrille = 'grille-3';
} elseif ($nbCartes <= 12) {
    $classeGrille = 'grille-4';
} elseif ($nbCartes <= 18) {
    $classeGrille = 'grille-6';
} else {
    $classeGrille = 'grille-6';
}

// Thème actuel
$theme = $_SESSION['theme'] ?? 'medieval';

// Préparer les données des cartes pour JavaScript
$cartesData = [];
foreach ($jeu as $i => $carte) {
    $cartesData[] = [
        'id' => $carte->getId(),
        'image' => $carte->getImage(),
        'trouvee' => $carte->getEstTrouvee()
    ];
}
?>

<!-- Script pour appliquer le thème au body -->
<script>document.body.classList.add('theme-<?= $theme ?>');</script>

<div class="game-container">

<!-- Barre de progression -->
<div class="progress-container">
    <div class="progress-bar" id="progress-bar"></div>
    <span class="progress-text"><span id="paires-trouvees">0</span> / <?= $_SESSION['nb_paires'] ?> paires</span>
</div>

<div class="info-bar">
    <a href="/game" class="btn-abandon">Abandonner</a>

    <div class="coups-box">
        <span>Coups :</span>
        <span id="compteur-coups">0</span>
    </div>

    <div class="timer-box">
       <span>Temps :</span>
       <span id="chrono" style="font-family: monospace; font-size: 1.2em;"><?= $chronoAffiche ?></span>
    </div>
</div>

<!-- Message Preview -->
<div id="preview-message" class="preview-message">
    <span>👀 Mémorisez les cartes !</span>
    <div id="preview-countdown">3</div>
</div>

<div id="plateau-jeu" class="<?= $classeGrille ?>">
    <?php foreach ($jeu as $i => $carte): ?>
        <div class="carte-conteneur <?= $carte->getEstTrouvee() ? 'trouvee' : '' ?>" 
             data-index="<?= $i ?>" 
             data-id="<?= $carte->getId() ?>"
             data-image="<?= $carte->getImage() ?>">
            <div class="carte-inner">
                <div class="carte-face carte-dos">
                    <?php 
                    $dosImage = 'dos.jpg';
                    if (($theme ?? 'medieval') === 'disney') {
                        $dosImage = 'dosdisney.jpg';
                    } elseif (($theme ?? 'medieval') === 'bisounours') {
                        $dosImage = 'dosbisounours.jpg';
                    } elseif (($theme ?? 'medieval') === 'winnie') {
                        $dosImage = 'doswinnie.jpg';
                    }
                    ?>
                    <img src="/assets/images/cards/<?= $dosImage ?>" alt="dos de carte" class="carte-img">
                </div>
                <div class="carte-face carte-front">
                    <img src="<?= $carte->getImage() ?>" alt="Carte Memory" class="carte-img">
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</div>

<script>
// Données du jeu
const nbPaires = <?= $_SESSION['nb_paires'] ?>;
const debutPartie = <?= $debut ?>;

// Sons du jeu
const sons = {
    flip: new Audio('data:audio/wav;base64,UklGRl9vT19teleWQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU'),
    match: null,
    error: null,
    victory: null
};

// Créer les sons avec Web Audio API
const audioCtx = new (window.AudioContext || window.webkitAudioContext)();

function playSound(type, frequency = 440, duration = 0.1) {
    const oscillator = audioCtx.createOscillator();
    const gainNode = audioCtx.createGain();
    
    oscillator.connect(gainNode);
    gainNode.connect(audioCtx.destination);
    
    if (type === 'flip') {
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        gainNode.gain.value = 0.1;
        duration = 0.05;
    } else if (type === 'match') {
        oscillator.frequency.value = 523.25; // Do
        oscillator.type = 'sine';
        gainNode.gain.value = 0.15;
        duration = 0.15;
        // Jouer une petite mélodie
        setTimeout(() => playNote(659.25, 0.1), 100); // Mi
        setTimeout(() => playNote(783.99, 0.15), 200); // Sol
    } else if (type === 'error') {
        oscillator.frequency.value = 200;
        oscillator.type = 'square';
        gainNode.gain.value = 0.08;
        duration = 0.2;
    } else if (type === 'victory') {
        // Fanfare de victoire
        playNote(523.25, 0.15);
        setTimeout(() => playNote(659.25, 0.15), 150);
        setTimeout(() => playNote(783.99, 0.15), 300);
        setTimeout(() => playNote(1046.50, 0.3), 450);
        return;
    }
    
    oscillator.start();
    oscillator.stop(audioCtx.currentTime + duration);
}

function playNote(freq, dur) {
    const osc = audioCtx.createOscillator();
    const gain = audioCtx.createGain();
    osc.connect(gain);
    gain.connect(audioCtx.destination);
    osc.frequency.value = freq;
    osc.type = 'sine';
    gain.gain.value = 0.15;
    osc.start();
    osc.stop(audioCtx.currentTime + dur);
}

// Initialiser le jeu fluide
document.addEventListener('DOMContentLoaded', function() {
    previewCards();
});

// Preview des cartes au début
function previewCards() {
    const cartes = document.querySelectorAll('.carte-conteneur:not(.trouvee)');
    const previewMsg = document.getElementById('preview-message');
    const countdown = document.getElementById('preview-countdown');
    
    // Montrer toutes les cartes
    cartes.forEach(carte => carte.classList.add('retournee'));
    previewMsg.classList.add('visible');
    
    // Compte à rebours
    let count = 3;
    const timer = setInterval(() => {
        count--;
        countdown.textContent = count;
        if (count <= 0) {
            clearInterval(timer);
            // Cacher les cartes
            cartes.forEach(carte => carte.classList.remove('retournee'));
            previewMsg.classList.remove('visible');
            // Démarrer le jeu
            initMemoryGame();
        }
    }, 1000);
}

function initMemoryGame() {
    let cartesRetournees = [];
    let verrouille = false;
    let coups = 0;
    let pairesTrouvees = 0;

    const cartes = document.querySelectorAll('.carte-conteneur:not(.trouvee)');
    const compteurCoups = document.getElementById('compteur-coups');
    const progressBar = document.getElementById('progress-bar');
    const pairesText = document.getElementById('paires-trouvees');

    // Compter les paires déjà trouvées
    pairesTrouvees = document.querySelectorAll('.carte-conteneur.trouvee').length / 2;
    updateProgress();

    cartes.forEach(carte => {
        carte.addEventListener('click', function() {
            if (verrouille) return;
            if (this.classList.contains('retournee')) return;
            if (this.classList.contains('trouvee')) return;

            // Son de flip
            playSound('flip');

            // Retourner la carte
            this.classList.add('retournee');
            cartesRetournees.push(this);

            if (cartesRetournees.length === 2) {
                coups++;
                compteurCoups.textContent = coups;
                verifierPaire();
            }
        });
    });

    function verifierPaire() {
        verrouille = true;
        const [carte1, carte2] = cartesRetournees;
        const id1 = carte1.dataset.id;
        const id2 = carte2.dataset.id;

        if (id1 === id2) {
            // Paire trouvée !
            playSound('match');
            
            setTimeout(() => {
                carte1.classList.add('trouvee');
                carte2.classList.add('trouvee');
                pairesTrouvees++;
                updateProgress();
                
                resetTour();

                // Vérifier victoire
                if (pairesTrouvees === nbPaires) {
                    playSound('victory');
                    setTimeout(() => {
                        sauvegarderEtTerminer();
                    }, 1000);
                }
            }, 300);
        } else {
            // Pas une paire - Shake !
            playSound('error');
            
            setTimeout(() => {
                carte1.classList.add('shake');
                carte2.classList.add('shake');
                
                setTimeout(() => {
                    carte1.classList.remove('retournee', 'shake');
                    carte2.classList.remove('retournee', 'shake');
                    resetTour();
                }, 500);
            }, 800);
        }
    }

    function updateProgress() {
        const percent = (pairesTrouvees / nbPaires) * 100;
        progressBar.style.width = percent + '%';
        pairesText.textContent = pairesTrouvees;
    }

    function resetTour() {
        cartesRetournees = [];
        verrouille = false;
    }

    function sauvegarderEtTerminer() {
        // Envoyer le résultat au serveur
        window.location.href = '/game/bravo';
    }

    // Chronomètre en temps réel
    function updateChrono() {
        const maintenant = Math.floor(Date.now() / 1000);
        const elapsed = maintenant - debutPartie;
        const minutes = Math.floor(elapsed / 60).toString().padStart(2, '0');
        const secondes = (elapsed % 60).toString().padStart(2, '0');
        document.getElementById('chrono').textContent = minutes + ':' + secondes;
    }

    setInterval(updateChrono, 1000);
    updateChrono();
}
</script>