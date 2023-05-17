<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use gift\app\services\prestations\PrestationsService as PrestationsService;

class GetCategorieAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface {
        $prestaService = new PrestationsService();
        $categories = $prestaService->getCategories();
        $html = <<<HTML
        <html>
            <head>
                <title>Catégories</title>
            </head>
            <body>
                <center><h1>Catégories</h1></center>
                <br>
        HTML;

        $html .= '<ul>';

        foreach ($categories as $categorie) {
            $html .= <<<HTML
                <li> {$categorie['id']} : <a href="/categories/{$categorie['id']}"> {$categorie['libelle']} </a></li>
                <br>
            HTML;
        }
        $html .= '</ul>';

        $html .= <<<HTML
            <br>
            <a href="/categories/add"><button>Ajouter une catégorie</button></a>
            </body>
        </html>
        HTML;
        $response->getBody()->write($html);
        return $response;
    }
}