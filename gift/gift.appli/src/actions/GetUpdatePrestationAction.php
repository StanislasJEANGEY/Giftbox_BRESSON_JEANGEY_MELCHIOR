<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\categories\CategorieService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetUpdatePrestationAction extends AbstractAction {

	/**
	 * Méthode qui permet d'afficher la page de modification d'une prestation
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
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		if (!isset($args['id'])) {
			throw new ServiceException("L'id n'existe pas", 400);
		}
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();
		$id = $args['id'];
		$prestaService = new PrestationsService();
		$prestation = $prestaService->getPrestationById($id);
        $categService = new CategorieService();
		$categories = $categService->getCategories();
		if ($request->getMethod() === 'POST') {
			$prestaService->getUpdatePrestation($id, $request->getParsedBody());
            header("Location: /prestations/{$prestation['id']}");
			exit();
		}
        $view = Twig::fromRequest($request);
        return $view->render($response, 'UpdatePrestationView.twig', [
            'liste_categ' => $categories, 'prestation' => $prestation, 'estConnecte' => $estConnecte
        ]);
	}
}