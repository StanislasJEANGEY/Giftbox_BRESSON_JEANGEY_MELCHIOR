<?php
use Slim\App;


return function (App $app) {

    $app->get('[/]', \gift\app\actions\GetAccueilAction::class)->setName("accueil");
    $app->get('/categories[/]', \gift\app\actions\GetCategorieAction::class)->setName("categories");
    $app->get('/categories/add[/]', \gift\app\actions\GetAddCategorieAction::class)->setName("add_categorie_get");
    $app->post('/categories/add[/]', \gift\app\actions\GetAddCategorieAction::class)->setName("add_categorie_post");
	//$app->get('/categories/del[/]', \gift\app\actions\GetDelCategorieAction::class);
    $app->get('/categories/{id}[/]', \gift\app\actions\GetCategorieByIdAction::class)->setName("categorie_by_id");
	//$app->get('/categories/{id}/prestations', \gift\app\actions\GetPrestationsCategorieAction::class);
	$app->get('/prestations[/]', \gift\app\actions\GetPrestationAction::class)->setName("prestations");
	$app->get('/prestations/add[/]', \gift\app\actions\GetAddPrestationAction::class)->setName("add_prestation_get");
	$app->post('/prestations/add[/]', \gift\app\actions\GetAddPrestationAction::class)->setName("add_prestation_post");
	$app->get('/prestations/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class)->setName("prestation_by_id");
	$app->post('/prestations/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class)->setName("prestation_by_id_post");
	$app->get('/categories/{id:\d+}/prestations', \gift\app\actions\GetPrestationsByCategorieAction::class)->setName("prestations_by_categorie");
	$app->get('/prestations/{id}/update', \gift\app\actions\GetUpdatePrestationAction::class)->setName("update_prestation_get");
	$app->post('/prestations/{id}/update', \gift\app\actions\GetUpdatePrestationAction::class)->setName("update_prestation_post");
    $app->get('/box[/]', \gift\app\actions\GetBoxAction::class)->setName("box");
    $app->get('/box/add[/]', \gift\app\actions\GetAddBoxAction::class)->setName("add_box_get");
    $app->post('/box/add[/]', \gift\app\actions\GetAddBoxAction::class)->setName("add_box_post");
    $app->get('/box/{id}[/]', \gift\app\actions\GetBoxByIdAction::class)->setName("box_by_id");
    $app->get('/box/{id}/prestations', \gift\app\actions\GetPrestationsByBoxAction::class)->setName("prestations_by_box");
};