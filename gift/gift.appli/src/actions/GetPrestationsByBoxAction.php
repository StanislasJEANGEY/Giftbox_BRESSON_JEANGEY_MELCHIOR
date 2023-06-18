<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\box\BoxService;
use gift\app\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

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
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();

        $prestations = $boxService->getPrestationByBoxId($id);
        $total = 0;
        foreach ($prestations as $prestation) {
            $total += $prestation['tarif'];
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationByBoxView.twig', [
            'box' => $box, 'liste_presta' => $prestations, 'id' => $id, 'url' => $url, 'total' => $total, 'estConnecte' => $estConnecte
        ]);
    }
}