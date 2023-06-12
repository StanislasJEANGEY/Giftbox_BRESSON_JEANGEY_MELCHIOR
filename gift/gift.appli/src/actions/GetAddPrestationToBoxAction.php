<?php

namespace gift\app\actions;

use Exception;
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
        $prestationService = new PrestationsService();
        $prestations = $prestationService->getPrestations();

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('box_by_id');


        $view = Twig::fromRequest($request);
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            try {
                CsrfService::check($data['csrf_token']);
            } catch (Exception $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            try {
                $prestationService->getAddPrestationToBox($data);
            } catch (PrestationsServiceException $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            return $response->withHeader('Location', $url)->withStatus(302);
        } else {
            try {
                $csrf = CsrfService::generate();
                $view->render($response, 'AddPrestationToBoxView.twig', [
                    'csrf_token' => $csrf, 'prestations' => $prestations
                ]);
            } catch (Exception $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
        }
        return $response;
    }
}