<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class GetAddPrestationToCategorieAction extends AbstractAction {

	/**
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$prestaService = new PrestationsService();
		$prestations = $prestaService->getPrestations();

		$previousURL = $request->getHeaderLine('Referer');
		$idCategorie = "";
		$parts = explode('/', $previousURL);
		$index = array_search('categorie', $parts);
		if ($index !== false && isset($parts[$index + 1])) {
			$idCategorie = $parts[$index + 1];
		}

		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('prestations_by_categorie', ['id' => $idCategorie]);

		$prestationsToAdd = [];

		$view = Twig::fromRequest($request);

		if ($request->getMethod() === 'POST') {
			foreach ($prestations as $prestation) {
				if (isset($_POST[$prestation->getId()])) {
					$prestationsToAdd[] = $prestation;
				}
			}
			$data = $request->getParsedBody();
			$data['libelle'] = filter_var($data['libelle'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$data['prestations'] = $prestationsToAdd;
			try {
				CsrfService::check($data['csrf_token']);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
			try {
				$prestaService->getCreatePrestation($data);
			} catch (PrestationsServiceException $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
			return $response->withHeader('Location', $url)->withStatus(302);
		} else {
			try {
				$csrf = CsrfService::generate();
				$view->render($response, 'AddPrestationToCategorieView.twig', [
					'csrf_token' => $csrf,
					'prestation' => $prestations,
					'idCategorie' => $idCategorie
				]);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
		}
		return $response;
	}
}