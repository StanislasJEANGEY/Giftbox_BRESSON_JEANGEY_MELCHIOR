<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetPrestationsByIdAction extends AbstractAction {

	/**
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		if (!isset($args['id'])) {
			throw new PrestationsServiceException("L'id n'existe pas", 400);
		}

        $previousURL = $request->getHeaderLine('Referer');
        $url = '';
        $id_url = '';
        $id = $args['id'];
        $prestaService = new PrestationsService();
        $prestation = $prestaService->getPrestationById($id);
        $view = Twig::fromRequest($request);

        if (str_contains($previousURL, 'box')){
            $url = 'prestations_by_box';
            $parts = explode('/box/', $previousURL);
            if (count($parts) > 1) {
                $id = $parts[1];
            }
        } else {
            $url = 'prestations_by_categorie';
            $parts = explode('/box/', $previousURL);
            if (count($parts) > 1) {
                $id = $parts[1];
            }
        }
        return $view->render($response, 'PrestationByIdView.twig', [
            'prestation' => $prestation, 'previousURL' => $previousURL, 'id' => $id_url
        ]);
	}
}