<?php

use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;

require_once __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../views/', ['cache' => false]);
$app->add (TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

return $app;