<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByIdAction extends AbstractAction {

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $prestation = \gift\app\models\Prestation::find($id);
        $html = <<<HTML
        <html>
            <head>
                <title>Prestation</title>
            </head>
            <body>
                <center><h1>$prestation->libelle</h1></center>
                <br>
                <p>Prix : $prestation->tarif €</p>
                <br>
                <p>Description : $prestation->description</p>
                <br>
                <img src=$prestation->img alt="image de $prestation->img">
            </body>
        </html>
        HTML;

		$response->getBody()->write($html);
		return $response;
	}
}