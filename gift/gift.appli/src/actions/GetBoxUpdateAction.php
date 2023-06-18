<?php

namespace gift\app\actions;

use gift\app\models\Box;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\box\BoxService;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetBoxUpdateAction extends AbstractAction {

	/**
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws ServiceException
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();
		$id = $args['id'];
		$boxService = new BoxService();
		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('box');
		$box = $boxService->getBoxById($id);
		$boxStatut = $box['statut'];
		if ($request->getMethod() === 'POST') {
			if ($box['statut'] != Box::VALIDATED) {
				$boxService->getUpdateBox($id, $request->getParsedBody());
			}
			header("Location: $url");
			exit();
		}
		$view = Twig::fromRequest($request);
		return $view->render($response, 'UpdateBoxView.twig', [
			'box' => $box, 'boxStatut' => $boxStatut, 'estConnecte' => $estConnecte
		]);
	}
}