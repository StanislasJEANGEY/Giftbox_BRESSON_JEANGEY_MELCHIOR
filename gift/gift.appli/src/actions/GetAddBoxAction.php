<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\box\BoxService;
use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class GetAddBoxAction extends AbstractAction
{
	/**
	 * Méthode qui permet d'afficher la page d'ajout de box
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $boxService = new BoxService();
        $routeContext = RouteContext::fromRequest($request);

        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();

        $view = Twig::fromRequest($request);

        if ($estConnecte['role'] == 2){
            $url = 'box';
        } else {
            $url = 'box_perso';
        }
        if ($request->getMethod() === "POST"){
            $data = $request->getParsedBody();
            $data['libelle'] = filter_var($data['libelle'], FILTER_SANITIZE_SPECIAL_CHARS);
            $data['description'] = filter_var($data['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            $data['message_kdo'] = filter_var($data['message_kdo'], FILTER_SANITIZE_SPECIAL_CHARS);
            try{
                CsrfService::check($data['csrf_token']);
            }catch(Exception $e){
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            try{
                $boxService->createBox($data);
            } catch (Exception $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            return $response->withHeader('Location', $url)->withStatus(302);
        } else {
            try{
                $csrf = CsrfService::generate();
                $boxs = $boxService->getBox();
                $params = $request->getQueryParams();
                if (isset($params['box'])) {
                    $box = $boxService->getBoxById($params['box']);
                } else {
                    $box = null;
                }
                $view->render($response, 'AddBoxView.twig', [
                    'csrf_token' => $csrf, 'estConnecte' => $estConnecte,
                    'boxs' => $boxs, 'box' => $box, 'url' => $url
                ]);
            } catch (Exception $e) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
        }
        return $response;
    }
}