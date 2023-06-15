<?php

namespace gift\api\actions;

use Exception;
use gift\api\services\box\BoxService;
use gift\app\services\prestations\PrestationsServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetBoxByIdAction extends AbstractAction
{
    /**
     * @throws PrestationsServiceException | Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!isset($args['id'])) {
            throw new PrestationsServiceException("L'id n'existe pas", 400);
        }

        $id = $args['id'];
        $boxService = new BoxService();
        $box = $boxService->getBoxById($id);
        $elemBox= $box[0];

        $dataJson = [
            'type' => 'resource',
            'box' => [
                'id' => $elemBox['id'],
                'libelle' => $elemBox['libelle'],
                'description' => $elemBox['description'],
                'message_kdo' => $elemBox['message_kdo'],
                'statut' => $elemBox['statut'],
                'prestations' => []
            ]
        ];

        foreach ($elemBox['prestations'] as $prestation) {
            $prestaJson = [
                'libelle' => $prestation['libelle'],
                'description' => $prestation['description'],
                'contenu' => [
                    'box_id' => $elemBox['id'],
                    'presta_id' => $prestation['id'],
                    'quantite' => $prestation['contenu']['quantite']
                ]
            ];

            $dataJson['box']['prestations'][] = $prestaJson;
        }

//        $dataJson = json_encode($box, JSON_PRETTY_PRINT);
        $dataJson = json_encode($dataJson, JSON_PRETTY_PRINT);
        $response->getBody()->write($dataJson);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
