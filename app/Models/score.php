<?php

namespace App\Models;

use Core\Database;


class Score
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    /**
     * Enregistre un nouveau score en base de données
     * 
     */
    public function save($idUtilisateur, $temps, $nbPaires)
    {
        $pdo= Database::getPdo();

        $sql = "INSERT INTO scores (id_utilisateur, temps, nombre_paires, date_creation)
        VALUES (?, ?, ?, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUtilisateur, $temps, $nbPaires]);

        return $stmt;
    }
    /**
     * 
     * Récupère les 10 meilleurs scores avec le pseudo du joueur
     */
    public function getBestScores()
        {
            $sql = "SELECT scores.*, utilisateurs.login
            FROM scores
            JOIN utilisateurs ON scores.id_utilisateur = utilisateurs.id
            ORDER BY temps ASC, nombre_paires DESC
            LIMIT 10";

            return Database::query($sql)->fetchAll();//Appel à la statique
        }

        public function getUserHistory($idUtilisateur)
        {
            $pdo = Database::getPdo();

            $sql = "SELECT * FROM scores
            WHERE id_utilisateur = ?
            ORDER BY date_creation DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$idUtilisateur]);

            return $stmt->fetchAll();
        }
        public function getUserBest($idUtilisateur)
        {
        $pdo = Database::getPdo();

        $sql = "SELECT MIN(temps) as meilleur_temps
        FROM scores
        WHERE id_utilisateur = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUtilisateur]);

        return $stmt->fetch();

        }

        /**
         * Récupère les statistiques complètes d'un utilisateur
         */
        public function getUserStats($idUtilisateur)
        {
            $pdo = Database::getPdo();

            // Nombre total de parties
            $sql1 = "SELECT COUNT(*) as total_parties FROM scores WHERE id_utilisateur = ?";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute([$idUtilisateur]);
            $totalParties = $stmt1->fetch()['total_parties'];

            // Meilleur temps
            $sql2 = "SELECT MIN(temps) as meilleur_temps FROM scores WHERE id_utilisateur = ?";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([$idUtilisateur]);
            $meilleurTemps = $stmt2->fetch()['meilleur_temps'];

            // Temps moyen
            $sql3 = "SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(temps))) as temps_moyen FROM scores WHERE id_utilisateur = ?";
            $stmt3 = $pdo->prepare($sql3);
            $stmt3->execute([$idUtilisateur]);
            $tempsMoyen = $stmt3->fetch()['temps_moyen'];

            // Parties par niveau de difficulté
            $sql4 = "SELECT nombre_paires, COUNT(*) as nb_parties, MIN(temps) as meilleur 
                     FROM scores WHERE id_utilisateur = ? 
                     GROUP BY nombre_paires ORDER BY nombre_paires";
            $stmt4 = $pdo->prepare($sql4);
            $stmt4->execute([$idUtilisateur]);
            $parNiveau = $stmt4->fetchAll();

            // Dernières parties (10)
            $sql5 = "SELECT * FROM scores WHERE id_utilisateur = ? ORDER BY date_creation DESC LIMIT 10";
            $stmt5 = $pdo->prepare($sql5);
            $stmt5->execute([$idUtilisateur]);
            $dernieresParties = $stmt5->fetchAll();

            // Position au classement général
            $sql6 = "SELECT COUNT(*) + 1 as rang FROM scores 
                     WHERE temps < (SELECT MIN(temps) FROM scores WHERE id_utilisateur = ?)";
            $stmt6 = $pdo->prepare($sql6);
            $stmt6->execute([$idUtilisateur]);
            $rang = $stmt6->fetch()['rang'];

            return [
                'total_parties' => $totalParties,
                'meilleur_temps' => $meilleurTemps,
                'temps_moyen' => $tempsMoyen,
                'par_niveau' => $parNiveau,
                'dernieres_parties' => $dernieresParties,
                'rang' => $rang
            ];
        }
}