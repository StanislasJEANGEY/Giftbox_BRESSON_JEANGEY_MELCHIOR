<?php

namespace gift\appli\action;

class GetCategorieByIdAction extends Slim\App
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke(Request $request, Response $response, array $args)
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