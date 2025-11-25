<?php

namespace App\Models;

use Core\Database;


class score
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

        $sql = "INSERT INTO scores (id_utilisateurs, $temps, nombre_paires, date_creation)
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
}