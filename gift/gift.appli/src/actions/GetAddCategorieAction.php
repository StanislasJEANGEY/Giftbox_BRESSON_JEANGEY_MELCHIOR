<?php

namespace gift\app\actions;

use gift\app\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAddCategorieAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $html = <<<HTML
        <html>
            <head>
                <title>Ajouter une catégorie</title>
            </head>
            <body>
                <center><h1>Ajouter une catégorie</h1></center>
                <br>
                <form action="/categories" method="post">
                    <label for="libelle">Libelle</label>
                    <input type="text" name="libelle" id="libelle">
                    <br>
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description">
                    <br>
                    <input type="submit" value="Ajouter">
                </form>
            </body>
        </html>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}