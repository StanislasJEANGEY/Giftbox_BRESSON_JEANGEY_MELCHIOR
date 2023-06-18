<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;


return function (App $app) {

    $app->get('[/]', \gift\app\actions\GetAccueilAction::class)->setName("accueil");
    $app->get('/categories[/]', \gift\app\actions\GetCategorieAction::class)->setName("categories");
    $app->get('/categories/add[/]', \gift\app\actions\GetAddCategorieAction::class)->setName("add_categorie_get");
    $app->post('/categories/add[/]', \gift\app\actions\GetAddCategorieAction::class)->setName("add_categorie_post");
    //$app->get('/categories/del[/]', \gift\app\actions\GetDelCategorieAction::class);
    $app->get('/categories/{id}[/]', \gift\app\actions\GetCategorieByIdAction::class)->setName("categorie_by_id");
    //$app->get('/categories/{id}/prestations', \gift\app\actions\GetPrestationsCategorieAction::class);

    $app->get('/prestations/add[/]', \gift\app\actions\GetAddPrestationAction::class)->setName("add_prestation_get");
    $app->post('/prestations/add[/]', \gift\app\actions\GetAddPrestationAction::class)->setName("add_prestation_post");

    $app->group('/prestations', function (RouteCollectorProxy $group) {
        $group->get('[/{tri:.+}]', \gift\app\actions\GetPrestationAction::class)->setName("prestations");
    });

    $app->group('/prestationsId', function (RouteCollectorProxy $group) {
        $group->get('/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class)->setName("prestation_by_id");
        $group->post('/{id}[/]', \gift\app\actions\GetPrestationsByIdAction::class)->setName("prestation_by_id_post");
        $group->get('/{id}/update', \gift\app\actions\GetUpdatePrestationAction::class)->setName("update_prestation_get");
        $group->post('/{id}/update', \gift\app\actions\GetUpdatePrestationAction::class)->setName("update_prestation_post");
    });

    $app->get('/categories/{id}/prestations', \gift\app\actions\GetPrestationsByCategorieAction::class)->setName("prestations_by_categorie");

    $app->get('/box[/]', \gift\app\actions\GetBoxAction::class)->setName("box");
    $app->get('/box/perso[/]', \gift\app\actions\GetBoxPersoAction::class)->setName("box_perso");
    $app->get('/box/add[/]', \gift\app\actions\GetAddBoxAction::class)->setName("add_box_get");
    $app->post('/box/add[/]', \gift\app\actions\GetAddBoxAction::class)->setName("add_box_post");
    $app->get('/box/{id}[/]', \gift\app\actions\GetBoxByIdAction::class)->setName("box_by_id");
    $app->get('/box/{id}/prestations', \gift\app\actions\GetPrestationsByBoxAction::class)->setName("prestations_by_box");
	$app->get('/box/{id}/update[/]', \gift\app\actions\GetBoxUpdateAction::class)->setName("update_box_get");
	$app->post('/box/{id}/update[/]', \gift\app\actions\GetBoxUpdateAction::class)->setName("update_box_post");

    $app->get('/addPrestationToBox[/]', \gift\app\actions\GetAddPrestationToBoxAction::class)->setName("add_prestation_to_box_get");
    $app->post('/addPrestationToBox[/]', \gift\app\actions\GetAddPrestationToBoxAction::class)->setName("add_prestation_to_box_post");
    $app->get('/addPrestationToCateg[/]', \gift\app\actions\GetAddPrestationToCategorieAction::class)->setName("add_prestation_to_categorie_get");
    $app->post('/addPrestationToCateg[/]', \gift\app\actions\GetAddPrestationToCategorieAction::class)->setName("add_prestation_to_categorie_post");

    $app->get('/connexion[/]', \gift\app\actions\GetConnexionAction::class)->setName("connexion_get");
    $app->post('/connexion[/]', \gift\app\actions\GetConnexionAction::class)->setName("connexion_post");
    $app->get('/inscription[/]', \gift\app\actions\GetInscriptionAction::class)->setName("inscription_get");
    $app->post('/inscription[/]', \gift\app\actions\GetInscriptionAction::class)->setName("inscription_post");
    $app->get('/deconnexion[/]', \gift\app\actions\GetDeconnexionAction::class)->setName("deconnexion_get");
    $app->post('/deconnexion[/]', \gift\app\actions\GetDeconnexionAction::class)->setName("deconnexion_post");

    $app->get('/paiementBox/{id}[/]', \gift\app\actions\GetPaiementBoxAction::class)->setName("paiement_box_get");
    $app->post('/paiementBox/{id}[/]', \gift\app\actions\GetPaiementBoxAction::class)->setName("paiement_box_post");

};
