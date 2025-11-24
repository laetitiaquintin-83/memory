<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\Card;

class GameController extends BaseController {

    public function index() {
        // Si le joueur à cliqué sur jouer Soumission du formulaire
        if (is_post()) {
            //sécurisation de l'entrée utilisateur
            $nbPaires = intval (post ('nombre-paires'));
            $deck = [];

            //Création du paquet de cartes
            for ($c = 1; $c <= $nbPaires; $c++) {
                $image = "https://picsum.photos/id/" . ($c + 10) . "/100";

                $carte1 = new Card($c, $image);
                $carte2 = new Card($c, $image);

                $deck[] = $carte1;
                $deck[] = $carte2;

            }

            // Mélange et sauvegarde 
            shuffle($deck);
            $_SESSION['jeu'] = $deck;

            $_SESSION['debut_partie'] = time();

            $_SESSION['nb_paires'] =  $nbPaires;

        // Redirection vers le plateau de jeu
        header("Location: game/plateau");// Ou le chremin vers ta route de jeu
        exit(); // Toujours arreter le script aprés une redirection
        }

        // Sinon ( arrivée sur la page), on affiche l'accueil
        $this->render('game/index');
    }
    public function plateau() 
    {
        if(!isset($_SESSION['jeu'])){
            header("location: index");
            exit();
        }
        
        $deck = $_SESSION['jeu'];

        $this->render('game/plateau', ['jeu' => $deck]);

    }
    public function play()
{
    if (!isset($_SESSION['jeu'])) {
        header("Location: /game");
        exit();
    }
    
    $index = get("i");
    $deck = $_SESSION['jeu'];

    $deck[$index]->setEstRetournee(true);

    $cartesRetournees = [];
    foreach ($deck as $carte) {
        if ($carte->getEstRetournee() && !$carte->getEstTrouvee()) {
            $cartesRetournees[] = $carte;
        }
    }
    
    if (count($cartesRetournees) == 2) {
        $carteA = $cartesRetournees[0];
        $carteB = $cartesRetournees[1];

        if ($carteA->getId() === $carteB->getId()) {
            // ✅ Paire trouvée
            $carteA->setEstTrouvee(true);
            $carteB->setEstTrouvee(true);
        } else {
            // ✅ CORRECTION : Modifier AVANT render()
            // 1. On cache les cartes pour la prochaine fois
            $carteA->setEstRetournee(false);
            $carteB->setEstRetournee(false);
            $_SESSION['jeu'] = $deck;
            
            // 2. On affiche avec refresh (utilisateur voit brièvement les cartes)
            header("Refresh: 1; url=/game/plateau");
            $this->render('game/plateau', ['jeu' => $deck]);
            exit();
        }
    }

    // Sauvegarde
    $_SESSION['jeu'] = $deck;

    // Vérification victoire
    $toutEstTrouve = true;
    foreach ($deck as $carte) {
        if (!$carte->getEstTrouvee()) {
            $toutEstTrouve = false;
            break;
        }
    }
    
    if ($toutEstTrouve) {
        header("Location: /game/bravo");
        exit();
    }

    header("Location: /game/plateau");
    exit();
}
public function bravo()
{
    if (!isset($_SESSION['jeu']) || !isset($_SESSION['debut_partie'])){
        header("Location: /game");
        exit();
    }

    $fin = time();
    $debut = $_SESSION['debut partie'];
    $dureeEnSecondes = $fin - $debut;

    $tempsFormatSQL = gmdate("H:i:s", $dureeEnSecondes);

   $nbPaires = $_SESSION['nb_paires'];
    $idUtilisateur = $_SESSION['user']['id'] ?? 1;

    $db = new \Core\Database();

    $sql = "INSERT INTO scores (id_utilisateur, temps, nombre_paires, date_creation) VALUES (?, ?, ?, NOW())";

    $db->query($sql, [$idUtilisateur, $tempsFormatSQL, $nbPaires]);

    unset($_SESSION['jeu']);
    unset($_SESSION['debut_partie']);
    unset($_SESSION['nb_paires']);

    $this->render('game/bravo', [
        'temps' => $tempsFormatSQL,
        'paires' =>$nbPaires
    ]);
  
}

}