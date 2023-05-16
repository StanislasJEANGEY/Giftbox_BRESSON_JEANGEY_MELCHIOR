<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByIdAction extends AbstractAction {

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
        $html = <<<HTML
        <html>
            <head>
                <title>Prestation</title>
            </head>
            <body>
                <center><h1>{$prestation['libelle']}</h1></center>
                <br>
                <p>Prix : {$prestation['tarif']} €</p>
                <br>
                <p>Description : {$prestation['description']}</p>
                <br>
                <img src=../../../shared/img/{$prestation['img']} alt="image de {$prestation['img']}">
                <br>
                <br>
                <button><a href="/prestations/{$prestation['id']}/update">Modifier</a></button>
            </body>
        </html>
        HTML;

		$response->getBody()->write($html);
		return $response;
	}
}