<?php

namespace gift\appli\action;

use http\Client\Response;

abstract class AbstractAction {

	abstract public function __invoke($request, $response, $args) : Response;

}