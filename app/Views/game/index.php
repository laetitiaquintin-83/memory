<div class="home-container">
    <h1>Memory</h1>
    <p> class="subtitle">Pret à tester votre mémoire ?</p>

    >form action="" method="POST">

    <?php if(function_exists('csrf_token')): ?>
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <?php endif; ?>

        <div class="form group">
            <label for="nb_paires">Niveau de difficulté :</label>
            <select name="nombre_paires" id="nb_paires">
                <option value="3">Débutant (3 paires - 6 cartes)</option>
                 <option value="6" selected>Normal (6 paires - 12 cartes)</option>
                  <option value="9">Difficile (9 paires - 18 cartes)</option>
                   <option value="12">Expert (12 paires - 24 cartes)</option>
    </select>
    </div>

    <button type="submit" class="btn-play"> Lancer la partie</button>
    </form>