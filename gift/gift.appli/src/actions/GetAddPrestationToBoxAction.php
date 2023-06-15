<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\box\BoxService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class GetAddPrestationToBoxAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $boxService = new BoxService();
        $prestationService = new PrestationsService();
        try {
            $prestations = $prestationService->getPrestations();
        } catch (ServiceException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());

        }


        $previousURL = $request->getHeaderLine('Referer');
        $idBox = "";
        $parts = explode('/', $previousURL);
        $index = array_search('box', $parts);
        if ($index !== false && isset($parts[$index + 1])) {
            $idBox = $parts[$index + 1];
        }

        $routeContext = RouteContext::fromRequest($request);

        $view = Twig::fromRequest($request);
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            try {
                CsrfService::check($data['csrf_token']);
            } catch (Exception $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            try {
                $boxService->addPrestationToBox($data);
            } catch (ServiceException $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            $url = $routeContext->getRouteParser()->urlFor('prestations_by_box',['id' => $data['idBox']]);
            return $response->withHeader('Location', $url)->withStatus(302);
        } else {
            try {
                $csrf = CsrfService::generate();
                $quantite = $boxService->getPrestationByBoxIdWithQuantite($idBox);
                $view->render($response, 'AddPrestationToBoxView.twig', [
                    'csrf_token' => $csrf, 'prestations' => $prestations, 'idBox' => $idBox,
                    'presta_quantite' => $quantite
                ]);
            } catch (Exception $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
        }
        return $response;
    }
}
