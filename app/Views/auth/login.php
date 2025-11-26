<?php if (has_flash_messages('error')): ?>
     <div class="alert alert-error">
         <?php foreach (get_flash_messages('error') as $message): ?>
             <p><?= esc($message) ?></p>
         <?php endforeach; ?>
     </div>
 <?php endif; ?>

 <?php if (has_flash_messages('success')): ?>
     <div class="alert alert-success">
         <?php foreach (get_flash_messages('success') as $message): ?>
             <p><?= esc($message) ?></p>
         <?php endforeach; ?>
     </div>
 <?php endif; ?>

<div class="auth-container">
    <h1>Connexion</h1>
    <form action="" method="POST">
        <div class="form-group">
            <input type="text" name="login" placeholder="Login" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Mot de passe" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <p>Pas encore de compte ? <a href="/auth/register">S'inscrire</a></p>
</div>