<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use gift\app\services\box\BoxService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetPaiementBoxAction extends AbstractAction
{


    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $routeContext = RouteContext::fromRequest($request);
        $id = $args['id'];
        $boxService = new BoxService();
        $box = $boxService->getBoxById($id);
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();
        $url = $routeContext->getRouteParser()->urlFor('box_perso');

        if ($request->getMethod() === 'POST') {
            $boxService->updateStatut($id, 3);
            $response = $response->withHeader('Location', $url)->withStatus(302);
        }


        return $view->render($response, 'PaiementBoxView.twig', [
            'estConnecte' => $estConnecte, 'box' => $box
        ]);
    }

}