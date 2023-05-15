<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/vendor/autoload.php';

require_once __DIR__ . '/../src/services/utils.php';

use gift\app\services\utils\Eloquent;

Eloquent::init(__DIR__ . '/../src/conf/gift.db.conf.ini');

/* application boostrap */
$app = (require_once __DIR__ . '/../src/conf/bootstrap.php');

/* routes loading */
(require_once __DIR__ . '/../src/conf/routes.php')($app);

/* application run */
$app->run();