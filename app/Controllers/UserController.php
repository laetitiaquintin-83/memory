<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\User;
use App\Models\Score;

class UserController extends BaseController
{
    public function register( )
        {
            if (is_post()){
                $login = post('login');
                $password = post('password');
                $email = post('email');
                $nom = post('nom');
                $prenom = post('prenom');

                //Validation des champs
                if (empty($login)|| empty($password)|| empty ($email)|| empty($nom) || empty ($prenom)){
                    set_flash ('error', 'Tous les champs sont obligatoires');
                    $this->render('auth/register');
                    return;
                }
                //validation email
                if (!validate_email($email)){
                    set_flash('error', 'Email invalide');
                    $this->render('auth/register');
                    return;
                }
                //validation longueur du mot de passe 
                if (strlen($password) <6) {
                    set_flash('error', 'Le mot de passe doit contenir au moins 6 caractères');
                    $this->render('auth/register');
                    return;
                }
                $userModel = new User();
                //verifier si le login est déjà pris
                if ($userModel->exists($login)){
                    set_flash('error', 'Ce login est déjà pris !') ;
                     $this->render('auth/register');
                    return;
                }
            
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $userModel->create($login, $hashedPassword, $email, $nom, $prenom);
                set_flash ('success', 'Inscription reussie! Vous pouvez maintenant vous connecter.');
                header("Location: /auth/login");
                exit();
                        
            }
            $this->render('auth/register');
        }

            public function login()
            {
                if(is_post()){
                    $login = post('login');
                    $password = post('password');

                    $userModel = new User();

                    $user = $userModel->findByLogin($login);

                    if ($user && password_verify($password, $user['password'])){

                        $_SESSION['user'] =[
                            'id'=> $user['id'],
                            'login'=> $user['login'],
                            'nom'=>$user['nom']
                        ];

                         header("Location: /game");
                exit();
            } else {
                // ✅ Utilisation de set_flash pour cohérence
                set_flash('error', 'Identifiants incorrects.');
                $this->render('auth/login');
                return;
            }
                }
                $this->render('auth/login');
            }
                public function logout()
                {
                    session_destroy();
                    header("Location: /");
                    exit();
                }

                public function profile()
                {
                    //Sécurité
                    if (!isset($_SESSION['user'])){
                        header("Location: /auth/login");
                        exit();
                    }
                    $userId = $_SESSION['user']['id'];
                    $userModel = new User();
                    $scoreModel = new Score();
                    $message = null;
                    //traitement du formulaire
                    if (is_post()) {
                        $login = post ('login');
                        $email = post('email');
                        $nom = post('nom');
                        $prenom = post('prenom');
                        $password = post('password');

                        // Appel au modèle avec TOUS les champs
            $userModel->update($login, $email, $nom, $prenom, $password);

            // Mise à jour de la session (pour que l'affichage reste à jour sans se reconnecter)
            $_SESSION['user']['login'] = $login;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['nom'] = $nom;
            $_SESSION['user']['prenom'] = $prenom;

            set_flash('success', 'Profil mis à jour avec succès !');
        }

        // 3. Récupération des données fraîches de l'utilisateur
        // C'est mieux de récupérer les infos en BDD pour être sûr d'avoir les dernières versions
        $currentUser = $userModel->findById($userId);

        // 4. Récupération stats
        $historique = $scoreModel->getUserHistory($userId);
        $bestScore = $scoreModel->getUserBest($userId);

        // 5. Envoi à la vue (on envoie $currentUser pour pré-remplir les champs)
        $this->render('auth/profile', [
            'user' => $currentUser,
            'historique' => $historique,
            'bestScore' => $bestScore,
            'message' => $message
        ]);
    }
}
                

        
        
   
