<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\User;

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

            }
        
   
