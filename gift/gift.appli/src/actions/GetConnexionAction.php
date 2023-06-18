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

            $authService = new AuthentificationService();
            $view = Twig::fromRequest($request);
            $routeContext = RouteContext::fromRequest($request);
            $url = $routeContext->getRouteParser()->urlFor('accueil');

            if ($request->getMethod() === 'POST') {
                $data = $request->getParsedBody();

                $email = $data['email'];
                $password = $data['password'];

                // Authentifier l'utilisateur
                $success = $authService->getConnexion($email, $password);

                if ($success) {
                    $response = $response->withHeader('Location', $url)->withStatus(302);
                } else {
                    // Afficher le formulaire de connexion avec un message d'erreur
                    return $view->render($response, 'ConnexionView.twig', ['error' => 'Identifiants invalides']);
                }
            }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'ConnexionView.twig');

        }
}
