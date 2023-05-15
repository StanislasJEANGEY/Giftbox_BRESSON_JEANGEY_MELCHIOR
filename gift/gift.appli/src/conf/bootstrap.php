<?php
use gift\app\services\utils\Eloquent;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

//Eloquent::init(__DIR__ . '/../gift.db.conf.ini');

return $app;