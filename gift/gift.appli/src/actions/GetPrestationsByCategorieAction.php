<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByCategorieAction extends AbstractAction {

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $categorie = \gift\app\models\Categorie::find($id);
        $html = <<<HTML
        <html>
            <head>
                <title>Catégorie</title>
            </head>
            <body>
                <center><h1>$categorie->libelle</h1></center>
        HTML;

        $prestations = \gift\app\models\Prestation::where('cat_id', '=', $id)->get();
        $html .= '<ul>';
        foreach ($prestations as $presta) {
            $html .= <<<HTML
                <li><a href="/prestations/$presta->id"> $presta->libelle </a> </li>
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