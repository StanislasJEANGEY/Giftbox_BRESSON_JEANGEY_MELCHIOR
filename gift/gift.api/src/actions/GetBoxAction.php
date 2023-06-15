<?php

namespace gift\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use gift\api\services\box\BoxService as BoxService;

class GetBoxAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface {
        $boxService = new BoxService();
        $categories = $boxService->getBox();

        return //TODO: return json
    }
}