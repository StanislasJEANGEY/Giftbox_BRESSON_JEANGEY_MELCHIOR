<?php

namespace gift\app\actions;

use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetPrestationAction extends AbstractAction {

	/**
	 * @throws SyntaxError
	 * @throws RuntimeError
	 * @throws LoaderError
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$prestaService = new PrestationsService();
        $tri = $request->getQueryParams()['tri'] ?? '';


        if ($tri == 'asc'){
            $prestations = $prestaService->getPrestationsByPrixCroissant();
        } elseif ($tri == 'desc'){
            $prestations = $prestaService->getPrestationsByPrixDecroissant();
        } else {
            $prestations = $prestaService->getPrestations();
        }

        $view = Twig::fromRequest($request);
		$view->render($response, 'PrestationView.twig', [
			'list_presta' => $prestations, 'tri' => $tri
		]);
		return $response;
	}

}