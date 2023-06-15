<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetPrestationsByIdAction extends AbstractAction {

	/**
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		if (!isset($args['id'])) {
			throw new ServiceException("L'id n'existe pas", 400);
		}

        $previousURL = $request->getHeaderLine('Referer');
        $id_url = '';
        $id = $args['id'];
        $prestaService = new PrestationsService();
        $prestation = $prestaService->getPrestationById($id);

        $view = Twig::fromRequest($request);

        if (str_contains($previousURL, 'box')){
            $url = 'prestations_by_box';;
            $parts = explode('/', $previousURL);
            $index = array_search('box', $parts);

            if ($index !== false && isset($parts[$index + 1])) {
                $id_url = $parts[$index + 1];
            }
        } else if(str_contains($previousURL, 'categories')){
            $url = 'prestations_by_categorie';
            $parts = explode('/', $previousURL);
            $index = array_search('categories', $parts);

            if ($index !== false && isset($parts[$index + 1])) {
                $id_url = $parts[$index + 1];
            }
        } else {
            $url = 'prestations';
        }
        return $view->render($response, 'PrestationByIdView.twig', [
            'prestation' => $prestation, 'previousURL' => $url, 'id_url' => $id_url
        ]);
	}
}