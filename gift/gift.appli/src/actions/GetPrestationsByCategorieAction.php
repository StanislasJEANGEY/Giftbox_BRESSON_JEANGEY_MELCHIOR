<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\categories\CategorieService;
use gift\app\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetPrestationsByCategorieAction extends AbstractAction {

	/**
	 * Méthode qui permet d'afficher la page des prestations par catégorie
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();
        $id = $args['id'];
        $url = 'prestaions_by_categorie';
        $categService = new CategorieService();
        $categorie = $categService->getCategorieById($id);
        $prestaService = new PrestationsService();
        $prestations = $prestaService->getPrestationByCategorieId($id);
        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationByCategorieView.twig', [
            'categories' => $categorie, 'liste_presta' => $prestations, 'id' => $id, 'url' => $url, 'estConnecte' => $estConnecte
        ]);
    }
}