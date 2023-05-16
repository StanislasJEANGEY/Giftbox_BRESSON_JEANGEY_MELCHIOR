<?php

namespace gift\app\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCategorieByIdAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $id = $args['id'];
        $categorie = \gift\app\models\Categorie::find($id);
        $html = <<<HTML
        <html>
            <head>
                <title>$categorie->libelle</title>
            </head>
            <body>
                <h1>$categorie->libelle</h1>
        HTML;

        $prestations = \gift\app\models\Prestation::where('cat_id', '=', $id)->get();
        $html .= '<ul>';
        foreach ($prestations as $presta) {
            $html .= <<<HTML
                <li> $presta->libelle : $presta->tarif €
                <br>
                Description : $presta->description
                <br>
                <img src=$presta->img alt="image de $presta->img">
                </li>
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