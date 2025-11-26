
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
 <div style="max-width: 400px; margin: 50px auto; text-align: center;">
    <h1>Inscription</h1>
    <form action="" method="POST">
        <input type="text" name="login" placeholder="Login" required style="display:block; width:100%; margin:10px 0; padding:10px;">
        <input type="email" name="email" placeholder="Email" required style="display:block; width:100%; margin:10px 0; padding:10px;">
        <input type="text" name="nom" placeholder="Nom" style="display:block; width:100%; margin:10px 0; padding:10px;">
        <input type="text" name="prenom" placeholder="Prénom" style="display:block; width:100%; margin:10px 0; padding:10px;">
        <input type="password" name="password" placeholder="Mot de passe" required style="display:block; width:100%; margin:10px 0; padding:10px;">
        
        <button type="submit" style="padding:10px 20px; background:#2ecc71; color:white; border:none; cursor:pointer;">S'inscrire</button>
    </form>
    <p>Déjà un compte ? <a href="/auth
    /login">Se connecter</a></p>
</div>