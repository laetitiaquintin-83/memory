🎮 Memory Game - Application PHP MVC
📋 Description
Application web de jeu Memory (jeu de cartes à retourner par paires) développée en PHP avec architecture MVC (Model-View-Controller). Les joueurs peuvent s'inscrire, se connecter et enregistrer leurs scores.

🚀 Fonctionnalités
🎯 Jeu
Choix de difficulté : 4 niveaux (3, 6, 9 ou 12 paires)
Système de jeu : Retournement de cartes, détection des paires
Chronomètre : Enregistrement du temps de partie
Victoire : Page de félicitations avec statistiques
👤 Authentification
Inscription : Création de compte avec validation
Connexion : Authentification sécurisée (password hash)
Déconnexion : Gestion de session
Validation : Email, longueur mot de passe (min 6 caractères)
🏆 Classement
Scores enregistrés : Temps, difficulté, date
Meilleurs scores : Affichage du top des joueurs
Historique : Consultation des performances
🛠️ Technologies utilisées
PHP 8.x : Langage serveur
MySQL : Base de données
PDO : Accès base de données sécurisé
Composer : Gestionnaire de dépendances
PSR-4 : Autoloading des classes
vlucas/phpdotenv : Gestion des variables d'environnement
Architecture MVC : Séparation des responsabilités
memory/
├── app/
│   ├── Controllers/         # Contrôleurs (logique métier)
│   │   ├── GameController.php
│   │   ├── HomeController.php
│   │   └── UserController.php
│   ├── Models/             # Modèles (accès données)
│   │   ├── Card.php
│   │   ├── Score.php
│   │   └── User.php
│   └── Views/              # Vues (interface utilisateur)
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       ├── game/
│       │   ├── index.php
│       │   ├── plateau.php
│       │   ├── bravo.php
│       │   └── classement.php
│       ├── home/
│       │   └── index.php
│       └── layouts/
│           └── base.php
├── core/                   # Noyau du framework
│   ├── BaseController.php
│   ├── Database.php
│   └── Router.php
├── public/                 # Racine web publique
│   ├── assets/
│   │   ├── css/
│   │   └── images/
│   └── index.php          # Point d'entrée
├── .env.example           # Template configuration
├── .gitignore
├── composer.json
├── helpers.php            # Fonctions utilitaires
└── README.md