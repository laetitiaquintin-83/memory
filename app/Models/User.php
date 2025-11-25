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
    /**
     * Met à jour les infos de l'utilisateur
     */

    public function update($login, $email, $nom, $prenom, $password = null)
    {
        //Sécurité; On récupère l'Id depuis la session
        if (!isset($_SESSION['user']['id'])){
            return false;
        }
        $id= $_SESSION['user']['id'];
        $pdo = Database::getPdo();

        //Si le mot de passe est fourni; on met tout à jour
        if ($password){
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UDPATE utilisateurs
            SET login = ?, email = ?, nom = ?, prenom = ?, password = ?
            WHERE id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$login, $email, $nom, $prenom, $hashedPassword, $id]);

        }else{
            //sinon, on ne touche pas au mot de passe
            $sql = "UPDATE utilisateurs
            SET login = ?, email = ?, nom = ?, prenom = ?
            WHERE id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$login, $email, $nom, $prenom, $id]);
        }

        return true;
    }
        public function findById($id)
        {
            $pdo = Database::getPdo();
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        }
    }