<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use gift\app\services\categories\CategorieService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetCategorieAction extends AbstractAction
{
	/**
	 * Méthode qui permet d'afficher la page des catégories
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface {
        $categService = new CategorieService();
        $categories = $categService->getCategories();
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'CategorieView.twig', [
            'list_categ' => $categories, 'estConnecte' => $estConnecte
        ]);
    }
}