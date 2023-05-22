<?php
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;


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
    $app->get('/categories/add[/]', \gift\app\actions\GetAddCategorieAction::class);
    $app->post('/categories/add[/]', \gift\app\actions\GetAddCategorieAction::class);
	//$app->get('/categories/del[/]', \gift\app\actions\GetDelCategorieAction::class);
    $app->get('/categories/{id}[/]', \gift\app\actions\GetCategorieByIdAction::class);
	//$app->get('/categories/{id}/prestations', \gift\app\actions\GetPrestationsCategorieAction::class);
	$app->get('/prestations/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class);
	$app->get('/categories/{id:\d+}/prestations', \gift\app\actions\GetPrestationsByCategorieAction::class);
	$app->get('/prestations/{id}/update', \gift\app\actions\GetUpdatePrestationAction::class);
	$app->post('/prestations/{id}/update', \gift\app\actions\GetUpdatePrestationAction::class);
	$app->post('/prestations/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class);
};