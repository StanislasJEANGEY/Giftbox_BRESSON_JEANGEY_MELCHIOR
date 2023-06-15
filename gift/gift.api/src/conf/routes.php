<?php
use Slim\App;


return function (App $api) {

    $api->get('/categories[/]', \gift\api\actions\GetCategorieAction::class)->setName("categories");
    $api->get('/categories/{id}[/]', \gift\api\actions\GetCategorieByIdAction::class)->setName("categorie_by_id");
	$api->get('/prestations[/]', \gift\api\actions\GetPrestationAction::class)->setName("prestations");
	$api->get('/prestations/{id}[/]', \gift\api\actions\GetPrestationsByIdAction::class)->setName("prestation_by_id");
	$api->post('/prestations/{id}[/]', \gift\api\actions\GetPrestationsByIdAction::class)->setName("prestation_by_id_post");
	$api->get('/categories/{id}/prestations', \gift\api\actions\GetPrestationsByCategorieAction::class)->setName("prestations_by_categorie");
    $api->get('/box[/]', \gift\api\actions\GetBoxAction::class)->setName("box");
    $api->get('/box/{id}[/]', \gift\api\actions\GetBoxByIdAction::class)->setName("box_by_id");
    $api->get('/box/{id}/prestations', \gift\api\actions\GetPrestationsByBoxAction::class)->setName("prestations_by_box");
};