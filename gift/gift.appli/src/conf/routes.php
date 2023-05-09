<?php
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

return function (App $app) {
    $app->get('/Giftbox_BRESSON_JEANGEY_MELCHIOR/Projet/src/gift.appli/src/scripts/td1.php', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
};