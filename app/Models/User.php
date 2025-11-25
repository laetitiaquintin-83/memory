<?php

namespace App\Models;

use Core\Database;

class user
{

    public function create($login, $password, $email, $nom, $prenom)
    {
        $pdo = Database::getPdo();

        $sql = "INSERT INTO utilisateurs (login, password, email, nom, prenom, date_creation)
        VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login, $password, $email, $nom, $prenom ]);

        return $stmt;

    }
 
    public function findByLogin($login)
    {
        $pdo = Database::getPdo();

        $sql = "SELECT * FROM utilisateurs WHERE login = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function exists($login)
    {
        $user = $this->findByLogin($login);
        return $user !== false;
    }
}