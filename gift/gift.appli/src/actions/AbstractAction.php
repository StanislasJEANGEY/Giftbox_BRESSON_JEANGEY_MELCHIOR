<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction {

	abstract public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface;

}