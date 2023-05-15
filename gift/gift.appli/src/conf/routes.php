<?php
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

define("CATEGS", [
    1=>['libelle'=>'restauration', 'description'=>'les restos quoua'],
    2=>['libelle'=>'hébergement', 'description'=>'les hotels, chambre quoua'],
    3=>['libelle'=>'attention', 'description'=>'les trucs qui font plaizzz'],
    4=>['libelle'=>'activités', 'description'=>'les trucs à faire'],
]);

define ("PRESTA", [
    "ABCD"=>['libelle'=>'diner', 'description'=>'diner de gala', 'tarif'=>100, 'unite'=>'par personne'],
    "EFGH"=>['libelle'=>'déjeuner', 'description'=>'déjeuner de gala', 'tarif'=>50, 'unite'=>'par personne'],
    "IJKL"=>['libelle'=>'saut parachute', 'description'=>'un saut en parachute filmé', 'tarif'=>400, 'unite'=>'par personne'],
    "MNOP"=>['libelle'=>'massage', 'description'=>'un massage de 1h', 'tarif'=>100, 'unite'=>'par personne'],
]);

return function (App $app) {
    $app->get('[/]', function (Request $request, Response $response, array $args) {
        $html = <<<HTML
        <html>
            <head>
                <title>Accueil</title>
            </head>
            <body>
                <center><h1>Accueil</h1></center>
                <h2>
                    <ul>
                        <li>1. <a href="/categories">Categories</a></li>
                    </ul>
                </h2>
            </body>
        </html>
        HTML;



        $response->getBody()->write($html);
        return $response;
    });

    $app->get('/categories[/]', \gift\app\actions\GetCategorieAction::class);
    $app->get('/categories/{id}[/]', \gift\app\actions\GetCategorieByIdAction::class);
//	$app->get('/prestations[/]', \gift\app\actions\GetPrestationsByIdAction::class);
//	$app->get('/categories/{id:\d+}/prestations', \gift\app\actions\GetPrestationsByCategorieAction::class);
};