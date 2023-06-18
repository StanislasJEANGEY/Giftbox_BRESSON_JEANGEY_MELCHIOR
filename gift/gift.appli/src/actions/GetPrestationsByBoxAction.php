<?php

namespace gift\app\actions;

use gift\app\services\authentification\AuthentificationService;
use gift\app\services\box\BoxService;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetPrestationsByBoxAction
{
	/**
	 * Méthode qui permet d'afficher la page des prestations d'une box
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws ServiceException
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
        if (isset($_SESSION['user_id'])) {
            $user = $authService->getCurrentUser();
            if ($user['role'] == 2) {
                $admin = true;
            } else {
                $admin = false;
            }
            if ($box['user_id'] == $user['id']) {
                $estProprio = true;
            } else {
                $estProprio = false;
            }
        } else {
            $admin = false;
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationByBoxView.twig', [
            'box' => $box, 'liste_presta' => $prestations, 'id' => $id, 'url' => $url, 'total' => $total, 'estConnecte' => $estConnecte,
            'admin' => $admin, 'estProprio' => $estProprio
        ]);
    }
}