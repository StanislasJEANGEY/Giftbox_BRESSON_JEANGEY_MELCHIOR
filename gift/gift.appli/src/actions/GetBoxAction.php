<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use gift\app\services\box\BoxService as BoxService;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetBoxAction
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface {
        $boxService = new BoxService();
        $categories = $boxService->getBox();
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();

        $user = $authService->getCurrentUser();
        if(isset($user)){
            $connected = true;
            if($user['role'] == 2){
                $admin = true;
            } else $admin = false;
        }else{
            $connected = false;
            $admin = false;
        }
        echo $admin;


        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxView.twig', [
            'list_box' => $categories, 'connected' => $connected,
            'estConnecte' => $estConnecte, 'admin ' => $admin
        ]);
    }
}