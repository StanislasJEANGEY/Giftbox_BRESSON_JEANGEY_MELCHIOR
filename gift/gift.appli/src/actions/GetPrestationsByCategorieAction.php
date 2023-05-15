<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByCategorieAction extends AbstractAction {

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$html = <<<HTML
        <html>
        <head>
        <title>Prestations</title>
        </head>
        <body>
        <h1>Prestations</h1>
        <ul>
            <li>1. <a href="/prestations/1">diner</a></li>
            <li>2. <a href="/prestations/2">déjeuner</a></li>
            <li>3. <a href="/prestations/3">saut parachute</a></li>
            <li>4. <a href="/prestations/4">massage</a></li>
        </ul></body></html>
HTML;
		$response->getBody()->write($html);
		return $response;
	}
}