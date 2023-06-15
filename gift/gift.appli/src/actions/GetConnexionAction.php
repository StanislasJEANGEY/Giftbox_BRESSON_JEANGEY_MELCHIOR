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
		$view->render($response, 'ConnexionView.twig');

		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('accueil');

		if ($request->getMethod() === 'POST') {
			$data = $request->getParsedBody();
			$email = $data['email'];
			$password = $data['password'];
			$authService = new AuthentificationService();
			try {
				$authService->getConnexion($email, $password);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
			$response = $response->withHeader('Location', $url);
			return $response->withStatus(302);
		}

		return $response;
	}

}