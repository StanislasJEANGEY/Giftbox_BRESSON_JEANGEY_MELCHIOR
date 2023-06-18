<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class  GetAccueilAction
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface {

        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();
        $view = Twig::fromRequest($request);
        return $view->render($response, 'AccueilView.twig', [
            'estConnecte' => $estConnecte,
        ]);
    }
}