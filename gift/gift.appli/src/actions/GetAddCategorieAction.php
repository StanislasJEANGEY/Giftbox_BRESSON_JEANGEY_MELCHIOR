<?php

namespace gift\app\actions;

use gift\app\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetAddCategorieAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $prestaService = new PrestationsService();
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $prestaService->getCreateCategorie($data['libelle'], $data['description']);
            header('Location: /categories');
			exit();
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'AddCategorieView.twig');
    }
}