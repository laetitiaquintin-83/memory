<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\Card;
use Core\Database;
use App\Models\Score;

class GameController extends BaseController
{
    public function index()
    {
        if (is_post()) {

            $nbPaires = intval(post('nombre_paires'));
            $theme = post('theme') ?? 'medieval';
            $deck = [];

            // Définir le décalage selon le thème
            // Princesse : cartes 1-12, Amis de Mickey : cartes 13-24, Bisounours : cartes 25-36, Winnie : cartes 37-48
            if ($theme === 'winnie') {
                $offset = 36;
            } elseif ($theme === 'bisounours') {
                $offset = 24;
            } elseif ($theme === 'disney') {
                $offset = 12;
            } else {
                $offset = 0;
            }

            for ($c = 1; $c <= $nbPaires; $c++) {
                $imageNum = $c + $offset;
                $image = "/assets/images/cards/" . $imageNum . ".jpg";

                $carte1 = new Card($c, $image);
                $carte2 = new Card($c, $image);

                $deck[] = $carte1;
                $deck[] = $carte2;
            }

            shuffle($deck);
            $_SESSION['jeu'] = $deck;
            $_SESSION['theme'] = $theme;

            // --- 🆕 AJOUTS POUR LE SCORE ---
            // On lance le chrono (heure actuelle en secondes)
            $_SESSION['debut_partie'] = time();

            // On retient la difficulté (nombre de paires)
            $_SESSION['nb_paires'] = $nbPaires;

            header("Location: /game/plateau");
            exit();
        }

        $this->render('game/index');
    }

    public function plateau()
    {
        if (!isset($_SESSION['jeu'])) {
            header("Location: /game");
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

        // Retourner la carte cliquée
        $deck[$index]->setEstRetournee(true);

        // Compter les cartes retournées (non trouvées)
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
                
                // Sauvegarder et rediriger
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
            } else {
                // ❌ Pas une paire - afficher les cartes puis les retourner
                $_SESSION['jeu'] = $deck;
                
                // Afficher les cartes retournées avec auto-refresh après 1 seconde
                header("Refresh: 1; url=/game/retourner");
                $this->render('game/plateau', ['jeu' => $deck]);
                exit();
            }
        }

        // Sauvegarde et redirection (1 seule carte retournée)
        $_SESSION['jeu'] = $deck;
        header("Location: /game/plateau");
        exit();
    }

    public function retourner()
    {
        if (!isset($_SESSION['jeu'])) {
            header("Location: /game");
            exit();
        }

        $deck = $_SESSION['jeu'];

        // Retourner toutes les cartes non trouvées
        foreach ($deck as $carte) {
            if (!$carte->getEstTrouvee()) {
                $carte->setEstRetournee(false);
            }
        }

        $_SESSION['jeu'] = $deck;
        header("Location: /game/plateau");
        exit();
    }

    public function bravo()
    {
        if (!isset($_SESSION['jeu']) || !isset($_SESSION['debut_partie'])) {
            header("Location: /game");
            exit();
        }


        //Calcul du temps (Durée = Maintenant - Début)
        $fin = time();
        $debut = $_SESSION['debut_partie'];
        $dureeEnSecondes = $fin - $debut;

        //On convertit les secondes en format "00.02.15" pour SQL (TIME) gmdate

        $tempsFormatSQL = gmdate("H:i:s", $dureeEnSecondes);

        $nbPaires = $_SESSION['nb_paires'];

        $idUtilisateur = $_SESSION['user']['id'] ?? 1;

        $scoreModel = new Score();
        $scoreModel->save($idUtilisateur, $tempsFormatSQL, $nbPaires);

        unset($_SESSION['jeu']);
        unset($_SESSION['debut_partie']);
        unset($_SESSION['nb_paires']);

        $this->render('game/bravo', [
            'temps' => $tempsFormatSQL,
            'paires' => $nbPaires
        ]);
    }
public function classement()
{
    $scoreModel = new Score();
     
    $scores = $scoreModel->getBestScores();

    $this->render('game/classement',['scores'=> $scores]);
}

public function galerie()
{
    // Récupérer toutes les images des cartes des deux thèmes
    $themes = [
        'medieval' => ['nom' => '👸 Princesse', 'debut' => 1, 'fin' => 12],
        'disney' => ['nom' => '🐭 Amis de Mickey', 'debut' => 13, 'fin' => 24],
        'bisounours' => ['nom' => '🐻 Bisounours', 'debut' => 25, 'fin' => 36],
        'winnie' => ['nom' => '🍯 Winnie', 'debut' => 37, 'fin' => 48]
    ];
    
    $galerie = [];
    foreach ($themes as $themeId => $theme) {
        $cartes = [];
        for ($i = $theme['debut']; $i <= $theme['fin']; $i++) {
            $cartes[] = [
                'id' => $i,
                'image' => "/assets/images/cards/" . $i . ".jpg",
                'nom' => "Carte " . $i
            ];
        }
        $galerie[$themeId] = [
            'nom' => $theme['nom'],
            'cartes' => $cartes
        ];
    }
    
    $this->render('game/galerie', ['galerie' => $galerie]);
}
   
}