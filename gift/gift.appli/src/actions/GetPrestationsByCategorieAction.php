<?php

namespace gift\app\actions;

use Exception;
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
        $prestaService = new PrestationsService();
        $categorie = $prestaService->getCategorieById($id);

        $prestations = $prestaService->getPrestationByCategorieId($id);
        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationByCategorieView.twig', [
            'categorie' => $categorie, 'liste_presta' => $prestations
        ]);
    }
}