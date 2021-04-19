<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ConnexionAction;

use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    
    //Route de base
    //Vérifie si la personne est déjà connecté
    //Sinon renvoie vers la route /connexion
    $app->group('/', function (Group $group) use ($app) {
        if( empty($_GET['code'])){
            $app->redirect('/', '/connexion', 301);
        }
        else{
            $group->get('', ConnexionAction::class);
        }
    });

    //Route de connexion
    $app->get('/connexion', function (Request $request, Response $response) {
        $response->getBody()->write('<button><a href="https://accounts.spotify.com/authorize?client_id=8e43f58a8786457dba7f442dcaa1e017&response_type=code&redirect_uri=http://localhost:8080/&state=34fFs29kd09">Connexion</button></a>
            ');
        return $response;
    });

};
