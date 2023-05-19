<?php

namespace gift\app\actions;
use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCategorieByIdAction extends AbstractAction
{

	/**
	 * @throws PrestationsServiceException | Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
		if (!isset($args['id'])) {
			throw new PrestationsServiceException("L'id n'existe pas", 400);
		}
        $id = $args['id'];
        $prestaService = new PrestationsService();
        $categories = $prestaService->getCategorieById($id);
        $html = <<<HTML
        <html lang="fr">
            <head>
                <title>Catégorie</title>
            </head>
            <body>
                <center><h1>{$categories['libelle']}</h1></center>
                <br>
                <p>Description : {$categories['description']}</p>
                <br>
                <h2><a href="/categories/{$categories['id']}/prestations">Prestations</a></h2>
            </body>
        </html>
        HTML;


        $response->getBody()->write($html);
        return $response;
    }
}