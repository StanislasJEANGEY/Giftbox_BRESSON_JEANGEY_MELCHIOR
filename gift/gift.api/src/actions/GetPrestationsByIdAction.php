<?php

namespace gift\api\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetPrestationsByIdAction extends AbstractAction {

	/**
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		if (!isset($args['id'])) {
			throw new PrestationsServiceException("L'id n'existe pas", 400);
		}


        return //TODO: return json
	}
}