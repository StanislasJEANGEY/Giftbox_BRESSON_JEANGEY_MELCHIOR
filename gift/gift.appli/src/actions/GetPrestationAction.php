<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use gift\app\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetPrestationAction extends AbstractAction {

	/**
	 * Méthode qui permet d'afficher la page des prestations
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$prestaService = new PrestationsService();
        $tri = $request->getQueryParams()['tri'] ?? '';
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();


        if ($tri == 'asc'){
            $prestations = $prestaService->getPrestationsByPrixCroissant();
        } elseif ($tri == 'desc'){
            $prestations = $prestaService->getPrestationsByPrixDecroissant();
        } else {
            $prestations = $prestaService->getPrestations();
        }

        $view = Twig::fromRequest($request);
		$view->render($response, 'PrestationView.twig', [
			'list_presta' => $prestations, 'tri' => $tri, 'estConnecte' => $estConnecte
		]);
		return $response;
	}

}