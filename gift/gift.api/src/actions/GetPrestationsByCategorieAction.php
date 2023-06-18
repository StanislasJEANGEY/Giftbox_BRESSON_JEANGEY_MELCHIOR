<?php

namespace gift\api\actions;

use Exception;
use gift\api\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationsByCategorieAction extends AbstractAction {

	/**
	 * Méthode qui retourne toutes les prestations d'une catégorie en particulier
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws ServiceException
	 * @throws Exception
	 */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!isset($args['id'])) {
            throw new ServiceException("L'id n'existe pas", 400);
        }
        $id = $args['id'];
        $prestaService = new PrestationsService();
        $prestations = $prestaService->getPrestationByCategorieId($id);

        $dataJson = [
            "type" => "collection",
            "count" => count($prestations),
            "prestations" => []
        ];

        foreach ($prestations as $prestation) {
            $dataJson["prestations"][] = [
                "prestations" => $prestation,
                "links" => [
                    "self" => ["href" => "/prestations/" . $prestation["id"] . "/"]
                ]
            ];
        }

        $dataJson = json_encode($dataJson, JSON_PRETTY_PRINT);
        $dataJson = str_replace('\\/', '/', $dataJson); // Remplace les "\" par "/"
        $response->getBody()->write($dataJson);
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }
}