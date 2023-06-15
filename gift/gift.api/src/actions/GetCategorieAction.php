<?php

namespace gift\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use gift\api\services\prestations\PrestationsService as PrestationsService;


class GetCategorieAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $prestaService = new PrestationsService();
        $categories = $prestaService->getCategories();


        $dataJson = [
            'type' => 'collection',
            'count' => count($categories),
            'categories' => []
        ];

        foreach ($categories as $category) {
            $dataJson['categories'][] = [
                'categories' => $category,
                'links' => [
                    'self' => ['href' => '/categories/' . $category['id'] . '/']
                ]
            ];
        }

        $dataJson = json_encode($dataJson, JSON_PRETTY_PRINT);

        $response->getBody()->write($dataJson);
        return $response->withHeader('Content-Type', 'application/json');
    }
}