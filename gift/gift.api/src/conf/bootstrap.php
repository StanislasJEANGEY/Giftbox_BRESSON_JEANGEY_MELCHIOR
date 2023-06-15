<?php

use Slim\Factory\AppFactory;


require_once __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

return $app;