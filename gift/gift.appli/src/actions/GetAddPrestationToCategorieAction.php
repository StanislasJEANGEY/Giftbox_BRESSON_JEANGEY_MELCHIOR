<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\categories\CategorieService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class GetAddPrestationToCategorieAction extends AbstractAction
{
	/**
	 * Méthode qui permet d'afficher la page d'ajout d'une prestation à une catégorie
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		$categService = new CategorieService();
        $prestaService = new PrestationsService();
		$prestations = $prestaService->getPrestations();
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();

		$previousURL = $request->getHeaderLine('Referer');
		$idCategorie = "";
		$parts = explode('/', $previousURL);
		$index = array_search('categories', $parts);
		if ($index !== false && isset($parts[$index + 1])) {
			$idCategorie = $parts[$index + 1];
		}

		$routeContext = RouteContext::fromRequest($request);

		$view = Twig::fromRequest($request);

		if ($request->getMethod() === 'POST') {


			$data = $request->getParsedBody();

			try {
				CsrfService::check($data['csrf_token']);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}

			$categService->addPrestationToCategorie($data);
            $url = $routeContext->getRouteParser()->urlFor('prestations_by_categorie',['id' => $data['idCateg']]);

            return $response->withHeader('Location', $url)->withStatus(302);
		} else {
			try {
				$csrf = CsrfService::generate();
				$view->render($response, 'AddPrestationToCategorieView.twig', [
					'csrf_token' => $csrf,
					'prestations' => $prestations,
					'idCategorie' => $idCategorie,
                    'estConnecte' => $estConnecte,
				]);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
		}

		return $response;
	}
}
