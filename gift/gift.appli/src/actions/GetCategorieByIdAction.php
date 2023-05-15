<?php

namespace gift\app\actions;
use gift\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCategorieByIdAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $id = $args['id'];
        $cat = CATEGS[$id];

        $html = <<<HTML
    <html>
    <head>
    <title>Categorie $id</title>
    </head>
    <body>
    <h1>la Categorie $id</h1>
    <h2>{$cat['libelle']}</h2>
    <h2>{$cat['description']}</h2>
    </body></html>
HTML;
        $response->getBody()->write($html);
        return $response;
    }
}