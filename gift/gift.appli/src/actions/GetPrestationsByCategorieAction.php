<?php

namespace gift\app\actions;

use gift\app\services\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByCategorieAction extends AbstractAction {

    /**
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $prestaService = new PrestationsService();
        $categorie = $prestaService->getCategorieById($id);
        $html = <<<HTML
        <html>
            <head>
                <title>Catégorie</title>
            </head>
            <body>
                <center><h1>{$categorie['libelle']}</h1></center>
        HTML;

        $prestations = $prestaService->getPrestationByCategorieId($id);
        $html .= '<ul>';
        foreach ($prestations as $presta) {
            $html .= <<<HTML
                <li><a href="/prestations/{$presta['id']}"> {$presta['libelle']} </a> </li>
                <br>
            HTML;
        }
        $html .= '</ul>';
        $html .= <<<HTML
            </body>
        </html>
        HTML;
		$response->getBody()->write($html);
		return $response;
	}
}