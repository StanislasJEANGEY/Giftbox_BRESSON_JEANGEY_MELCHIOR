<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\box\BoxService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
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
        $prestations = $prestationService->getPrestations();

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('box_by_id');

        $previousURL = $request->getHeaderLine('Referer');
        $idBox = "";
        $parts = explode('/', $previousURL);
        $index = array_search('box', $parts);
        if ($index !== false && isset($parts[$index + 1])) {
            $idBox = $parts[$index + 1];
        }

        $view = Twig::fromRequest($request);
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            try {
                CsrfService::check($data['csrf_token']);
            } catch (Exception $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            try {
                $boxService->getAddPrestationToBox($data);
            } catch (PrestationsServiceException $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            return $response->withHeader('Location', $url)->withStatus(302);
        } else {
            try {
                $csrf = CsrfService::generate();
                $view->render($response, 'AddPrestationToBoxView.twig', [
                    'csrf_token' => $csrf, 'prestations' => $prestations, 'idBox' => $idBox
                ]);
            } catch (Exception $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
        }
        return $response;
    }
}