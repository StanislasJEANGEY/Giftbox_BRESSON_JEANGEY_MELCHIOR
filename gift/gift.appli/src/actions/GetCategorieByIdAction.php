<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\categories\CategorieService;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetCategorieByIdAction extends AbstractAction
{

	/**
	 * Méthode qui permet d'afficher la page d'une catégorie en particulier
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws ServiceException
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
		if (!isset($args['id'])) {
			throw new ServiceException("L'id n'existe pas", 400);
		}
        $id = $args['id'];
        $categService = new CategorieService();
        $categorie = $categService->getCategorieById($id);
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();


        $view = Twig::fromRequest($request);
        return $view->render($response, 'CategorieByIdView.twig', [
            'categories' => $categorie, 'estConnecte' => $estConnecte
        ]);

    }
}