<?php

namespace gift\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction {

	/**
	 * Méthode template pour les actions
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 */
	abstract public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface;

}