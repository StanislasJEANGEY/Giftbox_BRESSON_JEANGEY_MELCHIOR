<?php

namespace gift\api\actions;

use gift\api\services\categories\CategorieService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class GetCategorieAction extends AbstractAction
{
	/**
	 * Méthode qui retourne toutes les catégories
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $categService = new CategorieService();
        $categories = $categService->getCategories();


        $dataJson = [
            "type" => "collection",
            "count" => count($categories),
            "categories" => []
        ];

        foreach ($categories as $category) {
            $dataJson["categories"][] = [
                "categories" => $category,
                "links" => [
                    "self" => ["href" => "/categories/" . $category["id"] . "/"]
                ]
            ];
        }

        $dataJson = json_encode($dataJson, JSON_PRETTY_PRINT);
        $dataJson = str_replace('\\/', '/', $dataJson); // Remplace les "\" par "/"
        $response->getBody()->write($dataJson);
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }
}