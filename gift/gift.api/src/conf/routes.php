<?php
use Slim\App;


return function (App $api) {

    $api->get('[/]', \gift\api\actions\GetAccueilAction::class)->setName("home");
    $api->get('/categories[/]', \gift\api\actions\GetCategorieAction::class)->setName("categories");
	$api->get('/prestations[/]', \gift\api\actions\GetPrestationAction::class)->setName("prestations");
	$api->get('/categories/{id}/prestations', \gift\api\actions\GetPrestationsByCategorieAction::class)->setName("prestations_by_categorie");
    $api->get('/box/{id}[/]', \gift\api\actions\GetBoxByIdAction::class)->setName("box_by_id");
};