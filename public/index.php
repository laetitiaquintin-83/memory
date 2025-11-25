<?php
require_once __DIR__ . '/../vendor/autoload.php'; 

require_once __DIR__ .'/../helpers.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();}
// Chargement automatique des classes via Composer

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();



// Importation des classes avec namespaces pour éviter les conflits de noms
use Core\Router;

// Initialisation du routeur
$router = new Router();

// Définition des routes de l'application
// La route "/" pointe vers la méthode "index" du contrôleur HomeController
$router->get('/', 'App\\Controllers\\HomeController@index');

$router->get('/game', 'App\\Controllers\\GameController@index');
$router->post('/game', 'App\\Controllers\\GameController@index');
$router->get('/game/plateau', 'App\\Controllers\\GameController@plateau');
$router->get('/game/play', 'App\\Controllers\\GameController@play');
$router->get('/game/classement', 'App\\Controllers\\GameController@classement');
$router->get('/game/bravo', 'App\\Controllers\\GameController@bravo');


$router->get('/auth/register', 'App\\Controllers\\UserController@register');
$router->post('/auth/register', 'App\\Controllers\\UserController@register');

$router->get('/auth/login', 'App\\Controllers\\UserController@login');
$router->post('/auth/login', 'App\\Controllers\\UserController@login');



$router->get('/logout', 'App\\Controllers\\GameController@logout');
$router->post('/logout', 'App\\Controllers\\GameController@logout');
// La route "/articles" pointe vers la méthode "index" du contrôleur ArticleController


// Exécution du routeur :
// On analyse l'URI et la méthode HTTP pour appeler le contrôleur et la méthode correspondants
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
