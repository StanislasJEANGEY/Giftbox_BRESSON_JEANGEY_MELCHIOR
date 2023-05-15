<?php
use gift\app\services\utils\Eloquent;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

Eloquent::init(__DIR__ . '/../conf/gift.db.conf.ini');

return $app;