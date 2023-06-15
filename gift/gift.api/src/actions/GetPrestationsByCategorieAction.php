<?php

namespace gift\api\actions;

use Exception;
use gift\api\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByCategorieAction extends AbstractAction {

    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];
        $url = 'prestaions_by_categorie';
        $prestaService = new PrestationsService();
        $categorie = $prestaService->getCategorieById($id);

        $prestations = $prestaService->getPrestationByCategorieId($id);
        return //TODO: return json
    }
}