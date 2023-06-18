<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use gift\app\services\box\BoxService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetBoxPersoAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $boxService = new BoxService();
        $authService = new AuthentificationService();
        $userID = $authService->getCurrentUser();
        $box = $boxService->getBoxPerso($userID['id']);
        $estConnecte = $authService->getCurrentUser();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxPersoView.twig', [
            'list_box' => $box, 'estConnecte' => $estConnecte
        ]);
    }
}