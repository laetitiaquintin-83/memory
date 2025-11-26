<?php

/**
 * Layout principal
 * -----------------
 * Ce fichier définit la structure HTML commune à toutes les pages.
 * Il inclut dynamiquement le contenu spécifique à chaque vue via la variable $content.
 */
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">

  <!-- Titre de la page (sécurisé avec htmlspecialchars, valeur par défaut si non défini) -->
  <title><?= isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : 'Mini MVC' ?></title>

  <!-- Bonne pratique : rendre le site responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/global.css">


</head>

<body>
  <!-- Menu de navigation global -->
  <nav>
    <div class="nav-links">
      <a href="/">Accueil</a>
      <?php if (isset($_SESSION['user'])): ?>
        <a href="/game">Jouer</a>
        <a href="/game/classement">Classement</a>
        <a href="/auth/profile">Mon profil</a>
        <a href="/auth/logout">Déconnexion</a>
      <?php else: ?>
        <a href="/auth/register">S'inscrire</a>
        <a href="/auth/login">Se connecter</a>
      <?php endif; ?>
    </div>
    <?php if (isset($_SESSION['user'])): ?>
      <span class="welcome-user">👑 Bienvenue, <?= esc($_SESSION['user']['login']) ?></span>
    <?php endif; ?>
  </nav>

  <!-- Contenu principal injecté depuis BaseController -->
  <main>
    <?= $content ?>
  </main>
</body>

</html>