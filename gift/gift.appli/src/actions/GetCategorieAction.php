<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCategorieAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface {
        $html = <<<HTML
        <html>
            <head>
                <title>Catégories</title>
            </head>
            <body>
                <h1>Catégories</h1>
        HTML;

        $html .= '<ul>';
        $categories = \gift\app\models\Categorie::all();
        foreach ($categories as $categorie) {
            $html .= <<<HTML
                <li> $categorie->id : <a href="/categories/$categorie->id"> $categorie->libelle </a>
                <br>
                Description : $categorie->description
                </li>
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