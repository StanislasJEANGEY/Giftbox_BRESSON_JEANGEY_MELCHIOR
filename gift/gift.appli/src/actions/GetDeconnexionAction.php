<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class GetDeconnexionAction extends AbstractAction {

	/**
	 * Méthode invoquée lors de l'appel de l'action de déconnexion
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$authService = new AuthentificationService();
		$authService->getDeconnexion();

		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('accueil');
		return $response->withHeader('Location', $url)->withStatus(302);
	}
}