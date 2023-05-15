<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByIdAction extends AbstractAction {

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$id = $args['id'];
		$cat = CATEGS[$id];

		$html = <<<HTML
    <html>
    <head>
    <title>Prestations $id</title>
    </head>
    <body>
    <h1>La Prestation $id</h1>
    <h2>{$cat['libelle']}</h2>
    <h2>{$cat['description']}</h2>
    <h2>{$cat['tarif']}</h2>
    <h2>{$cat['unite']}</h2>
    </body></html>
HTML;
		$response->getBody()->write($html);
		return $response;
	}
}