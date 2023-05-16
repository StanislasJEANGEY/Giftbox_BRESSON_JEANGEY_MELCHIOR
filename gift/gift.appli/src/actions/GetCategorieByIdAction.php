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
                <title>Catégorie</title>
            </head>
            <body>
                <center><h1>$categorie->libelle</h1></center>
                <br>
                <p>Description : $categorie->description</p>
                <br>
                <h2><a href="/categories/$categorie->id/prestations">Prestations</a></h2>
            </body>
        </html>
        HTML;


        $response->getBody()->write($html);
        return $response;
    }
}