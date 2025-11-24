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

                $userModel = new User();

                if ($userModel->exists($login)){

                    echo "Ce login est déjà pris !";
                    return;
                }
            
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $userModel->create($login, $hashedPassword, $email, $nom, $prenom);

                header("Location:/login");
                exit();
            }
            $this->render('auth/register');
        }

            public function login()
            {
                if(is_post()){
                    $login = post('login');
                    $password = post('password');

                    $userModel = new user();

                    $user = $userModel->findByLogin($login);

                    if ($user && password_verify($password, $user['mot_de_passe'])){

                        $_SESSION['user'] =[
                            'id'=> $user['id'],
                            'login'=> $user['login'],
                            'nom'=>$user['nom']
                        ];

                        header("Location: /game");
                        exit();
                    } else{
                        echo "Identifiants incorrects.";
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
        
   
