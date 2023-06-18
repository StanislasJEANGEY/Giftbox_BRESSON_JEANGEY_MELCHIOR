<?php

namespace gift\app\actions;
use Exception;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\categories\CategorieService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetCategorieByIdAction extends AbstractAction
{

	/**
	 * @throws ServiceException | Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
		if (!isset($args['id'])) {
			throw new ServiceException("L'id n'existe pas", 400);
		}
        $id = $args['id'];
        $categService = new CategorieService();
        $categorie = $categService->getCategorieById($id);
        $authService = new AuthentificationService();
        $estConnecte = $authService->getCurrentUser();


        $view = Twig::fromRequest($request);
        return $view->render($response, 'CategorieByIdView.twig', [
            'categories' => $categorie, 'estConnecte' => $estConnecte
        ]);

    }
}