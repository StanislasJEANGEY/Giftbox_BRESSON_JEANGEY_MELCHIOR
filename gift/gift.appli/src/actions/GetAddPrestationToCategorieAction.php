<?php

namespace gift\app\actions;

use gift\app\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetAddPrestationToCategorieAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $prestationService = new PrestationsService();
        $prestation = $prestationService->getPrestations();
        $view = Twig::fromRequest($request);
        return $view->render($response, 'AddPrestationToView.twig', [
            'prestations' => $prestation
        ]);
    }
}