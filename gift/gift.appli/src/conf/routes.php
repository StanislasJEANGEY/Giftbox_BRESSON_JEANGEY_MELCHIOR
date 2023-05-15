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
    $app->get('/gift.appli/public/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Hello world!");
        return $response;
    });

    $app->get('/gift.appli/public/categories[/]', \gift\app\actions\GetCategorieAction::class);
    $app->get('/gift.appli/public/categories/{id}[/]', \gift\app\actions\GetCategorieByIdAction::class);
//$app->get('/gift.appli/public/categories/prestations[/]', \gift\app\actions\GetPrestationsByIdAction::class);
//    $app->get('/gift.appli/public/categories/{id}/prestations[/]', \gift\app\actions\GetPrestationsByCategorieAction::class);

//    /**
//     * Question 1
//     */
//    $app->get('/gift.appli/public/categories[/]', function (Request $request, Response $response, array $args) {
//        $html = <<<HTML
//        <html>
//        <head>
//        <title>Categories</title>
//        </head>
//        <body>
//        <h1>Categories</h1>
//        <ul>
//            <li>1. <a href="/gift.appli/public/categories/1">restauration</a></li>
//            <li>2. <a href="/gift.appli/public/categories/2">hébergement</a></li>
//            <li>3. <a href="/gift.appli/public/categories/3">attention</a></li>
//            <li>4. <a href="/gift.appli/public/categories/4">activités</a></li>
//        </ul></body></html>
//HTML;
//        $response->getBody()->write($html);
//        return $response;
//    });
//
//    /**
//     * Question 2
//     */
//    $app->get('/gift.appli/public/categories/{id}[/]', function (Request $request, Response $response, array $args) {
//        $id = $args['id'];
//        $cat = CATEGS[$id];
//
//        $html = <<<HTML
//    <html>
//    <head>
//    <title>Categorie $id</title>
//    </head>
//    <body>
//    <h1>la Categorie $id</h1>
//    <h2>{$cat['libelle']}</h2>
//    <h2>{$cat['description']}</h2>
//    </body></html>
//HTML;
//        $response->getBody()->write($html);
//        return $response;
//    });
};