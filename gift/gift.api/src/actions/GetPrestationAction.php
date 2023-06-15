<?php

namespace gift\api\actions;

use gift\api\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPrestationAction extends AbstractAction {


	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$prestaService = new PrestationsService();
		$prestations = $prestaService->getPrestations();


		return //TODO: return json
	}

}