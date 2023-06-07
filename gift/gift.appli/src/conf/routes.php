<?php
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;


return function (App $app) {
    $app->get('[/]', function (Request $request, Response $response, array $args) {
        $html = <<<HTML
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
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

    $app->get('/categories[/]', \gift\app\actions\GetCategorieAction::class)->setName("categories");
    $app->get('/categories/add[/]', \gift\app\actions\GetAddCategorieAction::class)->setName("add_categorie_get");
    $app->post('/categories/add[/]', \gift\app\actions\GetAddCategorieAction::class)->setName("add_categorie_post");
	//$app->get('/categories/del[/]', \gift\app\actions\GetDelCategorieAction::class);
    $app->get('/categories/{id}[/]', \gift\app\actions\GetCategorieByIdAction::class)->setName("categorie_by_id");
	//$app->get('/categories/{id}/prestations', \gift\app\actions\GetPrestationsCategorieAction::class);
	$app->get('/prestations/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class)->setName("prestation_by_id");
	$app->post('/prestations/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class)->setName("prestation_by_id_post");
	$app->get('/categories/{id:\d+}/prestations', \gift\app\actions\GetPrestationsByCategorieAction::class)->setName("prestations_by_categorie");
	$app->get('/prestations/{id}/update', \gift\app\actions\GetUpdatePrestationAction::class)->setName("update_prestation_get");
	$app->post('/prestations/{id}/update', \gift\app\actions\GetUpdatePrestationAction::class)->setName("update_prestation_post");
    $app->get('/box[/]', \gift\app\actions\GetBoxAction::class)->setName("box");
    $app->get('/box/{id}[/]', \gift\app\actions\GetBoxByIdAction::class)->setName("box_by_id");
    $app->get('/box/{id:\d+}/prestations', \gift\app\actions\GetPrestationsByBoxAction::class)->setName("prestations_by_box");
    //$app->get('/box/add[/]', \gift\app\actions\GetAddBoxAction::class)->setName("add_box_get");
    //$app->post('/box/add[/]', \gift\app\actions\GetAddBoxAction::class)->setName("add_box_post");
};