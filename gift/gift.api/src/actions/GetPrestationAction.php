<?php

namespace gift\api\actions;

use gift\api\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationAction extends AbstractAction {

	/**
	 * Méthode qui retourne toutes les prestations
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$prestaService = new PrestationsService();
		$prestations = $prestaService->getPrestations();

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