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

 <form action ="" method="POST">

 <div cmlass="form_group">
    <label>Login :</label>
    <input type="text" name="login" value="<?= $user['login']?>" required>
         </div>

         <div cmlass="form_group">
    <label>Email :</label>
    <input type="text" name="email" value="<?= $user['email']?>" required>
         </div>

         <div cmlass="form_group">
    <label>Nom :</label>
    <input type="text" name="nom" value="<?= $user['nom']?>">
         </div>

         <div cmlass="form_group">
    <label>Prenom :</label>
    <input type="text" name="prenom" value="<?= $user['prenom']?>" >
         </div>

         <div cmlass="form_group">
    <label>Nouveau mot de passe :</label>
    <input type="password" name="password" placeholder="(laisser vide pour ne pas changer)">
         </div>

         <button type="submit" class="btn_update">Mettre àjour</button>
         </form>