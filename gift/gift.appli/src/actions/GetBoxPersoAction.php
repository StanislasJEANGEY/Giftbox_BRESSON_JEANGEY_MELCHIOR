<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use gift\app\services\box\BoxService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetBoxPersoAction extends AbstractAction
{

	/**
	 * Méthode qui permet d'afficher la page des box perso
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
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