/**
 * Memory Medieval - Effets visuels
 * Particules dorées et animations
 */

// ========================================
// PARTICULES DORÉES
// ========================================
function createParticles() {
    const container = document.querySelector('.page-home');
    if (!container) return;

    // Créer le conteneur de particules
    const particlesContainer = document.createElement('div');
    particlesContainer.className = 'particles-container';
    container.prepend(particlesContainer);

    // Générer 50 particules
    for (let i = 0; i < 50; i++) {
        createParticle(particlesContainer);
    }
}

function createParticle(container) {
    const particle = document.createElement('div');
    particle.className = 'particle';

    // Position aléatoire
    particle.style.left = Math.random() * 100 + '%';
    particle.style.top = Math.random() * 100 + '%';

    // Taille aléatoire
    const size = Math.random() * 6 + 2;
    particle.style.width = size + 'px';
    particle.style.height = size + 'px';

    // Délai d'animation aléatoire
    particle.style.animationDelay = Math.random() * 5 + 's';
    particle.style.animationDuration = (Math.random() * 3 + 4) + 's';

    container.appendChild(particle);
}

// ========================================
// COMPTEUR DE COUPS
// ========================================
function initCoupsCounter() {
    const plateauJeu = document.getElementById('plateau-jeu');
    if (!plateauJeu) return;

    // Récupérer ou initialiser le compteur depuis sessionStorage
    let coups = parseInt(sessionStorage.getItem('memory_coups') || '0');

    // Afficher le compteur
    updateCoupsDisplay(coups);

    // Écouter les clics sur les cartes
    plateauJeu.addEventListener('click', function (e) {
        const carte = e.target.closest('.carte-conteneur');
        if (carte && !carte.classList.contains('trouvee')) {
            coups++;
            sessionStorage.setItem('memory_coups', coups);
            updateCoupsDisplay(coups);
        }
    });
}

function updateCoupsDisplay(coups) {
    const coupsBox = document.querySelector('.coups-box span:last-child');
    if (coupsBox) {
        coupsBox.textContent = coups;
    }
}

// Reset compteur quand on commence une nouvelle partie
function resetCoupsCounter() {
    sessionStorage.setItem('memory_coups', '0');
}

// ========================================
// FLIP CARTE AU CLIC
// ========================================
function initCardFlip() {
    const plateauJeu = document.getElementById('plateau-jeu');
    if (!plateauJeu) return;

    // Intercepter les clics sur les liens des cartes
    plateauJeu.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (!link) return;

        const carte = link.closest('.carte-conteneur');
        if (!carte || carte.classList.contains('trouvee')) return;

        // Empêcher la navigation immédiate
        e.preventDefault();

        // Ajouter la classe pour l'animation de flip
        carte.classList.add('flipping');

        // Après l'animation, naviguer vers le lien
        setTimeout(() => {
            window.location.href = link.href;
        }, 300);
    });
}

// ========================================
// ANIMATIONS D'ENTRÉE
// ========================================
function initAnimations() {
    // Animation fade-in pour les conteneurs (sauf les cartes)
    const containers = document.querySelectorAll('.game-container, .home-container, .auth-container, .bravo-container, .classement-container, .galerie-container');

    containers.forEach((container, index) => {
        container.style.opacity = '0';
        container.style.transform = 'translateY(30px)';

        setTimeout(() => {
            container.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, 100 + (index * 100));
    });
}

// ========================================
// CONFETTIS PAGE BRAVO
// ========================================
function createConfetti() {
    const bravoContainer = document.querySelector('.bravo-container');
    if (!bravoContainer) return;

    const confettiContainer = document.createElement('div');
    confettiContainer.className = 'confetti-container';
    bravoContainer.prepend(confettiContainer);

    const colors = ['#c9a227', '#f4d03f', '#ffd700', '#e8e8e8', '#fff'];

    for (let i = 0; i < 100; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
            confetti.style.animationDelay = Math.random() * 0.5 + 's';
            confettiContainer.appendChild(confetti);

            // Supprimer après animation
            setTimeout(() => confetti.remove(), 4000);
        }, i * 30);
    }
}

// ========================================
// INITIALISATION
// ========================================
document.addEventListener('DOMContentLoaded', function () {
    // Particules sur la page d'accueil
    createParticles();

    // Animations d'entrée
    initAnimations();

    // Compteur de coups
    initCoupsCounter();

    // Flip des cartes
    initCardFlip();

    // Confettis sur la page bravo
    createConfetti();

    // Reset compteur si on est sur la page de sélection
    if (document.querySelector('.home-container form')) {
        resetCoupsCounter();
    }
});
