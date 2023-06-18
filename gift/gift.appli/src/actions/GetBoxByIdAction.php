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

class GetBoxByIdAction extends AbstractAction{

	/**
	 * Méthode qui permet d'afficher la page d'une box en particulier
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 * @throws ServiceException
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        if (!isset($args['id'])) {
            throw new ServiceException("L'id n'existe pas", 400);
        }
        $previousURL = $request->getHeaderLine('Referer');
        $id = $args['id'];
        $boxService = new BoxService();
        $box = $boxService->getBoxById($id);
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();

        if (str_contains($previousURL, 'perso')){
            $url = 'box_perso';
        } else {
            $url = 'box';
        }

        if (isset($_SESSION['user_id'])) {
            if ($box['user_id'] == $estConnecte['id']) {
                $estProprio = true;
            } else {
                $estProprio = false;
            }
        } else {
            $estProprio = false;
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxByIdView.twig', [
            'box' => $box, 'estConnecte' => $estConnecte,
            'estProprio' => $estProprio, 'url' => $url]
        );
    }
}