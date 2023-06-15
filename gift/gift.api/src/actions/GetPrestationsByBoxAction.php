<?php

namespace gift\api\actions;

use Exception;
use gift\api\services\box\BoxService;
use gift\api\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByBoxAction
{
    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];
        $url = 'prestations_by_box';
        $boxService = new BoxService();
        $box = $boxService->getBoxById($id);

        $prestations = $boxService->getPrestationByBoxId($id);
        $total = 0;
        foreach ($prestations as $prestation) {
            $total += $prestation['tarif'];
        }
        return //TODO: return json
    }
}