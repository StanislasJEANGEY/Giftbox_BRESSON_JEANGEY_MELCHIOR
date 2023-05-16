<?php

namespace gift\app\actions;
use gift\app\services\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCategorieByIdAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $id = $args['id'];
        $prestaService = new PrestationsService();
        $categories = $prestaService->getCategorieById($id);
        $html = <<<HTML
        <html>
            <head>
                <title>Catégorie</title>
            </head>
            <body>
                <center><h1>{$categories['libelle']}</h1></center>
                <br>
                <p>Description : {$categories['description']}</p>
                <br>
                <h2><a href="/categories/{$categories['id']}/prestations">Prestations</a></h2>
            </body>
        </html>
        HTML;


        $response->getBody()->write($html);
        return $response;
    }
}