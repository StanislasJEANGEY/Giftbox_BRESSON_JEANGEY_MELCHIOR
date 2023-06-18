<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class GetAddPrestationAction extends AbstractAction
{
	/**
	 * Méthode qui permet d'afficher la page d'ajout d'une prestation
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		$prestaService = new PrestationsService();
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();

		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('prestations');

		$view = Twig::fromRequest($request);

		if ($request->getMethod() === 'POST') {
			$data = $request->getParsedBody();
			$data['libelle'] = filter_var($data['libelle'], FILTER_SANITIZE_SPECIAL_CHARS);
			$data['tarif'] = filter_var($data['tarif'], FILTER_SANITIZE_SPECIAL_CHARS);
			$data['description'] = filter_var($data['description'], FILTER_SANITIZE_SPECIAL_CHARS);

//			$uploadedFiles = $request->getUploadedFiles();
//			$image = $uploadedFiles['img'];

			try {
				CsrfService::check($data['csrf_token']);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}

			try {
				$prestaService->getCreatePrestation($data);
			} catch (ServiceException $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}

			return $response->withHeader('Location', $url)->withStatus(302);
		} else {
			try {
				$csrf = CsrfService::generate();
				$view->render($response, 'AddPrestationView.twig', [
					'csrf_token' => $csrf, 'estConnecte' => $estConnecte, 'url' => $url
				]);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
		}

		return $response;
	}
}
