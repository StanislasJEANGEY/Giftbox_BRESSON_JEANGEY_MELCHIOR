<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\categories\CategorieService;
use gift\app\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetPrestationsByCategorieAction extends AbstractAction {

    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];
        $url = 'prestaions_by_categorie';
        $categService = new CategorieService();
        $categorie = $categService->getCategorieById($id);
        $prestaService = new PrestationsService();
        $prestations = $prestaService->getPrestationByCategorieId($id);
        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationByCategorieView.twig', [
            'categories' => $categorie, 'liste_presta' => $prestations, 'id' => $id, 'url' => $url
        ]);
    }
}