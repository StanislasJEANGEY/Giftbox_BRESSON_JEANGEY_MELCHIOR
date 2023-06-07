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

class GetAddCategorieAction extends AbstractAction {

	/**
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$prestaService = new PrestationsService();

		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('categories');

		$view = Twig::fromRequest($request);

		if ($request->getMethod() === "POST") {
			$data = $request->getParsedBody();
			$data['libelle'] = filter_var($data['libelle'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$data['description'] = filter_var($data['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			try {
				CsrfService::check($data['csrf_token']);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
			try {
				$prestaService->getCreateCategorie($data);
			} catch (PrestationsServiceException $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
			return $response->withHeader('Location', $url)->withStatus(302);
		} else {
			try {
				$csrf = CsrfService::generate();
				$view->render($response, 'AddCategorieView.twig', [
					'csrf_token' => $csrf
				]);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
		}
		return $response;
	}

}