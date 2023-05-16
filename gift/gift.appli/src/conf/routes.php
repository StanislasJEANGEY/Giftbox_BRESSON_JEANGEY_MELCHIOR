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
    $app->get('/categories/{id}[/]', \gift\app\actions\GetCategorieByIdAction::class);
	$app->get('/prestations/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class);
	$app->get('/categories/{id:\d+}/prestations', \gift\app\actions\GetPrestationsByCategorieAction::class);
};