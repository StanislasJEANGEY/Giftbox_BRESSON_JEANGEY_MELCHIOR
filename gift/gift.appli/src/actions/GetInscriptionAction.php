<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetInscriptionAction extends AbstractAction {

	/**
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws LoaderError
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$view = Twig::fromRequest($request);
		$view->render($response, 'InscriptionView.twig');

		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('connexion_get');

		if ($request->getMethod() === 'POST') {
			$data = $request->getParsedBody();
			$nom = $data['nom'];
			$prenom = $data['prenom'];
			$email = $data['email'];
			$password = $data['password'];
			$authService = new AuthentificationService();
			$authService->getInscription($nom, $prenom, $email, $password);
			$response = $response->withHeader('Location', $url);
			return $response->withStatus(302);
		}
		return $response;
	}
}