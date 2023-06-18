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

        $userID = $authService->getCurrentUser();
        if(isset($userID)){
            $connected = true;
            if ($authService->isAdmin()) {
                $admin = true;
            } else {
                $admin = false;
            }
        }else{
            $connected = false;
            $admin = false;
        }


        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxView.twig', [
            'list_box' => $categories, 'connected' => $connected, 'admin' => $admin
        ]);
    }
}