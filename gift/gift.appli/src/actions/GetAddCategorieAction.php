<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\categories\CategorieService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
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
		$categorieService = new CategorieService();

		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('categories');
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();

		$view = Twig::fromRequest($request);

		if ($request->getMethod() === "POST") {
			$data = $request->getParsedBody();
			$data['libelle'] = filter_var($data['libelle'], FILTER_SANITIZE_SPECIAL_CHARS);
			$data['description'] = filter_var($data['description'], FILTER_SANITIZE_SPECIAL_CHARS);
			try {
				CsrfService::check($data['csrf_token']);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
			try {
				$categorieService->getCreateCategorie($data);
			} catch (ServiceException $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
			return $response->withHeader('Location', $url)->withStatus(302);
		} else {
			try {
				$csrf = CsrfService::generate();
				$view->render($response, 'AddCategorieView.twig', [
					'csrf_token' => $csrf, 'estConnecte' => $estConnecte
				]);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
		}
		return $response;
	}

}