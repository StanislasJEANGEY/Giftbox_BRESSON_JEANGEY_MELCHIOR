<?php

$app = \Slim\Factory\AppFactory::create();
$app->addRoutingMiddleware();
$app->setBasePath('/my/app');

$app->get('/hello/{name}', function (Request $request, Response $rs, $args) {
	$name = $args['name'];
	$rs->getBody()->write("Hello, $name");
	return $rs;
});