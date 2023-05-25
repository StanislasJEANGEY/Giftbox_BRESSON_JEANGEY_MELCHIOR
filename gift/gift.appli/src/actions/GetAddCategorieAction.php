<?php

namespace gift\app\actions;

use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetAddCategorieAction extends AbstractAction
{

	/**
	 * @throws SyntaxError
	 * @throws PrestationsServiceException
	 * @throws RuntimeError
	 * @throws LoaderError
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $prestaService = new PrestationsService();
        if ($request->getMethod() === 'POST') {
			$attributs = $request->getParsedBody();
			$prestaService->getCreateCategorie($attributs);
			return $response->withHeader('Location', '/categories')->withStatus(302);
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'AddCategorieView.twig');
    }
}