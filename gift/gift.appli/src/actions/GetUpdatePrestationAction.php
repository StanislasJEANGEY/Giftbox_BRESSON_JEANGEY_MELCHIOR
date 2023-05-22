<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetUpdatePrestationAction extends AbstractAction {

	/**
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		if (!isset($args['id'])) {
			throw new PrestationsServiceException("L'id n'existe pas", 400);
		}
		$id = $args['id'];
		$prestaService = new PrestationsService();
		$prestation = $prestaService->getPrestationById($id);
		$categories = $prestaService->getCategories();
		if ($request->getMethod() === 'POST') {
			$prestaService->getUpdatePrestation($id, $request->getParsedBody());
            header("Location: /prestations/{$prestation['id']}");
			exit();
		}
        $view = Twig::fromRequest($request);
        return $view->render($response, 'UpdatePrestationView.twig', [
            'liste_categ' => $categories, 'prestation' => $prestation
        ]);
	}
}