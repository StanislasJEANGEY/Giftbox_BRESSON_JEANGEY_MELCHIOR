<?php

namespace gift\api\actions;

use gift\api\services\box\BoxService;
use gift\api\services\prestations\PrestationsServiceException;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetBoxByIdAction extends AbstractAction
{
	/**
	 * Méthode qui permet d'afficher la page d'une box en particulier
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws ServiceException
	 * @throws PrestationsServiceException
	 */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!isset($args['id'])) {
            throw new ServiceException("L'id n'existe pas", 400);
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

        $dataJson = json_encode($dataJson, JSON_PRETTY_PRINT);
        $dataJson = str_replace('\\/', '/', $dataJson); // Remplace les "\" par "/"
        $response->getBody()->write($dataJson);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
