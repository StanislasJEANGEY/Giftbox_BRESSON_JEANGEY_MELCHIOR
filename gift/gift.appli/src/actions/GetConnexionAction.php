<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetConnexionAction extends AbstractAction {

	/**
	 * @throws SyntaxError
	 * @throws RuntimeError
	 * @throws LoaderError
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$view = Twig::fromRequest($request);

		if ($request->getMethod() === 'POST') {
			$data = $request->getParsedBody();
			$email = $data['email'] ?? '';
			$password = $data['password'] ?? '';

			// Valider les champs du formulaire
			if (empty($email) || empty($password)) {
				// Rediriger avec un message d'erreur si des champs sont vides
				$_SESSION['flash']['error'] = 'Veuillez remplir tous les champs.';
				$routeContext = RouteContext::fromRequest($request);
				$url = $routeContext->getRouteParser()->urlFor('connexion_get');
				return $response->withHeader('Location', $url)->withStatus(302);
			}

			$authService = new AuthentificationService();
			try {
				$loggedIn = $authService->getConnexion($email, $password);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}

			if ($loggedIn) {
				$routeContext = RouteContext::fromRequest($request);
				$url = $routeContext->getRouteParser()->urlFor('accueil');
			} else {
				$_SESSION['failed_login'] = true;
				$_SESSION['flash']['error'] = 'Identifiants invalides.';
				$routeContext = RouteContext::fromRequest($request);
				$url = $routeContext->getRouteParser()->urlFor('connexion_get');
			}
			return $response->withHeader('Location', $url)->withStatus(302);
		} else {
			$view->render($response, 'ConnexionView.twig');
			return $response;
		}
	}
}
